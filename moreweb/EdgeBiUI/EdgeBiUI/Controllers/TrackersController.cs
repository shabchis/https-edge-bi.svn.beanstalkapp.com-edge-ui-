﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;
using EdgeBiUI.Auxilary;

namespace EdgeBiUI.Controllers
{
    public class TrackersController : Controller
    {
        int acc_id = 0;
        string session_id = null;

        public TrackersController()
        {
            acc_id = AppState.AccountID;
            session_id = AppState.SessionID;
        }

        public ActionResult Index(int account, string session)
        {
            AppState.AccountID = account;
			AppState.SessionID = session;

            acc_id = AppState.AccountID;
            session_id = AppState.SessionID;

            Models.TrackersListModel m = new Models.TrackersListModel();

            using (var client = OltpLogicClient.Open(session_id))
            {
                // Load Channels
                Oltp.ChannelDataTable channels = client.Service.Channel_Get();
                m.Channels = channels.OrderBy(x => x.DisplayName).ToDictionary(c => c.ID, c => c.DisplayName);

                // Load Segments
                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);

                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_tracker_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Gateyway);
                    if (is_tracker_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList() });
                    }
                }
            }
            return View(m);
        }

        public PartialViewResult FindTrackers(FormCollection colls)
        {
            List<EdgeBiUI.Models.TrackerRowModel> L = new List<Models.TrackerRowModel>();

            using (var client = OltpLogicClient.Open(session_id))
            {
                if (client == null)
                    return PartialView("~/Views/Shared/_SessionExpiredView.cshtml");

                int? channelID = colls["Channel"] == "0" ? null : (int?)int.Parse(colls["Channel"]);

                int?[] segments = new int?[5];
                
                for(int i=1; i<6; i++)
                {
                    if (colls.AllKeys.Contains("Segment"+i))
                        segments[i-1]=int.Parse(colls["Segment"+i]);
                    else
                        segments[i-1] = null;
                    if (segments[i - 1] == 0)
                        segments[i - 1] = null;
                }

                string Identifier = colls["Identifier"];

                Oltp.GatewayDataTable t;
                if (Identifier.Equals(""))
                    t = client.Service.Gateway_GetGateways(acc_id, channelID, segments);
                else
                    t = client.Service.Gateway_GetByIdentifier(acc_id, Identifier);
                
                Dictionary<int, string> Channels = client.Service.Channel_Get().ToDictionary(c => c.ID, c => c.DisplayName);

                foreach (Oltp.GatewayRow g in t)
                {
                    Models.TrackerRowModel m1 = new Models.TrackerRowModel();
                    m1.TrackerID = g.GK;
                    m1.ChannelName = Channels[g.ChannelID];
                    if (g.IsNameNull())
                        m1.TrackerName = "";
                    else
                        m1.TrackerName = g.Name;
                    m1.Identifier = g.Identifier;

                    L.Add(m1);
                }
            }

            return PartialView("Table", L);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult EditTracker(string identifier)
        {
            Models.TrackerModel m = new Models.TrackerModel();

            using (var client = OltpLogicClient.Open(session_id))
            {
                if (client == null)
                    return PartialView("~/Views/Shared/_SessionExpiredView.cshtml");

                m.Tracker = client.Service.Gateway_GetByIdentifier(acc_id, identifier)[0];

                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_tracker_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Gateyway);
                    if (is_tracker_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = m.Tracker.Segment1; break;
                            case 2: value = m.Tracker.Segment2; break;
                            case 3: value = m.Tracker.Segment3; break;
                            case 4: value = m.Tracker.Segment4; break;
                            case 5: value = m.Tracker.Segment5; break;
                            default: value = m.Tracker.Segment1; break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }
                Oltp.ChannelDataTable channels = client.Service.Channel_Get();
                m.Channels = channels.ToDictionary(c => c.ID, c => c.DisplayName);
                m.LandingPages = client.Service.Page_Get(acc_id, null, true, -1).ToDictionary(p => p.GK, p => p.DisplayName);
                m.AppliedTo = GetReferenceData(m.Tracker, client);
            }


            return PartialView("TrackerDetails", m);

        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditTracker(string identifier, FormCollection coll)
        {
            Oltp.GatewayDataTable trackers;
            using (var client = OltpLogicClient.Open(session_id))
            {
                if (client == null)
                    return PartialView("~/Views/Shared/_SessionExpiredView.cshtml");

                trackers = client.Service.Gateway_GetByIdentifier(acc_id, identifier);

                trackers[0].Name = coll["TrackerName"];
                trackers[0].ChannelID = int.Parse(coll["Channel"]);
                trackers[0].DestinationURL = coll["DestinationURL"];
                trackers[0].PageGK = long.Parse(coll["LandingPage"]);
                foreach (string key in coll.Keys)
                {
                    if (key.Contains("trackerSegmentValue_"))
                    {
                        string segment_id = key.Split('_')[1];
                        int segmentID = int.Parse(segment_id);
                        int segmentValue = int.Parse(coll[key]);
                        switch (segmentID)
                        {
                            case 1: trackers[0].Segment1 = segmentValue; break;
                            case 2: trackers[0].Segment2 = segmentValue; break;
                            case 3: trackers[0].Segment3 = segmentValue; break;
                            case 4: trackers[0].Segment4 = segmentValue; break;
                            case 5: trackers[0].Segment5 = segmentValue; break;
                            default: break;
                        }
                    }
                }

                client.Service.Gateway_Save(trackers);
            }

            return Content("OK");
        }


        private string GetReferenceData(Oltp.GatewayRow tracker, OltpLogicClient client)
        {
            string referenceData = "";
            if (tracker.AdgroupGK < 1)
                return "";

            Oltp.AdgroupDataTable adg = client.Service.Adgroup_GetSingle(tracker.AdgroupGK);
            if (adg.Rows.Count < 1)
                return "";

            Oltp.AdgroupRow adgroup = adg[0];

            Oltp.CampaignDataTable cmpn = client.Service.Campaign_GetSingle(adgroup.CampaignGK);
            if (cmpn.Rows.Count > 0)
                referenceData += "<span>"+(cmpn.Rows[0] as Oltp.CampaignRow).Name + "</span> > ";
            referenceData += "<span>" + adgroup.Name + "</span> > ";

            
            if (!tracker.IsReferenceTypeNull())
            {
                if (tracker.ReferenceType == Oltp.GatewayReferenceType.Creative)
                {
                    Oltp.CreativeDataTable c = client.Service.Creative_GetSingle(tracker.ReferenceID);
                    if (c.Rows.Count > 0)
                        referenceData += "Creative: <span>" + (c[0] as Oltp.CreativeRow).Title + "</span>";
                }
                else
                {
                    Oltp.KeywordDataTable k = client.Service.Keyword_GetSingle(tracker.ReferenceID);
                    if (k.Rows.Count > 0)
                        referenceData += "Keyword: <span>" + (k[0] as Oltp.KeywordRow).Keyword + "</span>";
                }
            }

            return referenceData;
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult BatchUpdate()
        {
            Models.TrackersBatchModel m = new Models.TrackersBatchModel();

            using (var client = OltpLogicClient.Open(session_id))
            {
                if (client == null)
                    return PartialView("~/Views/Shared/_SessionExpiredView.cshtml");

                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_tracker_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Gateyway);
                    if (is_tracker_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = -1 });
                    }
                }
                Oltp.ChannelDataTable channels = client.Service.Channel_Get();
                m.Channels = channels.ToDictionary(c => c.ID, c => c.DisplayName);
                m.LandingPages = client.Service.Page_Get(acc_id, null, true, -1).ToDictionary(p => p.GK, p => p.DisplayName);
            }


            return PartialView("BatchTrackers", m);
        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult BatchUpdate(FormCollection coll)
        {
            List<long[]> ranges = new List<long[]>();
            string[] rangeStrings = coll["Range"].Split(',');
            bool error = false;
            
            foreach (string rangeString in rangeStrings)
            {                
                string[] boundStrings = rangeString.Split(new char[] { '-' }, StringSplitOptions.RemoveEmptyEntries);
                if (boundStrings.Length == 1 || boundStrings.Length == 2)
                {
                    long[] bounds = new long[boundStrings.Length];
                    for (int i = 0; i < bounds.Length; i++)
                    {
                        if (!long.TryParse(boundStrings[i], out bounds[i]))
                        {
                            error = true;
                            break;
                        }
                    }
                    if (bounds.Length==2)
                        if (bounds[0] >= bounds[1])
                        {
                            error = true;
                            break;
                        }
                    ranges.Add(bounds);
                }
                else
                {
                    error = true;
                    break;
                }
            }

            if (error)
                return Content("Error");

            int? channelID = coll["Channel"] == "-1" ? null : (int?)int.Parse(coll["Channel"]);
            long? pageGK = coll["LandingPage"] == "-1" ? null : (long?)long.Parse(coll["LandingPage"]);
            
            int?[] segments = new int?[5];
            for (int i = 1; i < 6; i++)
            {
                if (coll.AllKeys.Contains("batchtrackersSegmentValue_" + i))
                    segments[i - 1] = int.Parse(coll["batchtrackersSegmentValue_" + i]);
                else
                    segments[i - 1] = null;
                if (segments[i - 1] == -1)
                    segments[i - 1] = null;
            }

            int[] result;
            using (var client = OltpLogicClient.Open(session_id))
            {
                if (client == null)
                    return PartialView("~/Views/Shared/_SessionExpiredView.cshtml");

                result = client.Service.Gateway_BatchProperties(acc_id, ranges.ToArray(), channelID, pageGK, segments);
            }

            return Content(result[0] + "," + (result[0] - result[1]));
        }
    }
}
