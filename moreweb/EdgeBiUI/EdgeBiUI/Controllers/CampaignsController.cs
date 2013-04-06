using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;
using System.Data;

namespace EdgeBiUI.Controllers
{
    public class CampaignsController : Controller
    {
        int acc_id = 10035;

        public ActionResult Index()
        {
            Models.CampaignListModel m = new Models.CampaignListModel();
            using (var client = new OltpLogicClient(null))
            {
                //Oltp.CampaignDataTable t = client.Service.Campaign_Get(acc_id, null, null, null, false);
                m.Statuses = client.Service.CampaignStatus_Get().ToDictionary(x => x.ID, x => x.Name);
                m.Channels = client.Service.Channel_Get().ToDictionary(h => h.ID, h => h.Name);
                
                //foreach(Oltp.CampaignRow c in t)
                  //  m.Campaigns.Add(new Models.CampaignRowModel() { CampaignGK = c.GK, CampaignName = c.Name, Status = m.Statuses[c.StatusID], ChannelName = m.Channels[c.ChannelID] });
            }

            return View(m);
        }

        
        public PartialViewResult Find(FormCollection colls)
        {
            Models.CampaignListModel m = new Models.CampaignListModel();            
            using (var client = new OltpLogicClient(null))
            {
                m.Statuses = client.Service.CampaignStatus_Get().ToDictionary(x => x.ID, x => x.Name);
                m.Channels = client.Service.Channel_Get().ToDictionary(h => h.ID, h => h.Name);
                
                int? channelID = colls["Channel"] == "0" ? null : (int?)int.Parse(colls["Channel"]);
                int? statusID = colls["Status"] == "0" ? null : (int?)int.Parse(colls["Status"]);
                string textToSearch = colls["searchText"].Trim().Equals("") ? null : colls["searchText"].Trim()+"%";
                bool filterByAdgroup = colls["typeOfSearch"] == "adgroup";

                Oltp.CampaignDataTable t = client.Service.Campaign_Get(acc_id, channelID, statusID, textToSearch, filterByAdgroup);
                foreach (Oltp.CampaignRow c in t)
                    m.Campaigns.Add(new Models.CampaignRowModel() { CampaignGK = c.GK, CampaignName = c.Name, Status = m.Statuses[c.StatusID], ChannelName = m.Channels[c.ChannelID] });
            }

            return PartialView("Table", m.Campaigns);
        }

        public PartialViewResult GetAdgroupsForCampaign(long campaignGK)
        {
            List<Models.AdgroupRowModel> L = new List<Models.AdgroupRowModel>();
            using (var client = new OltpLogicClient(null))
            {
                Oltp.AdgroupDataTable t = client.Service.Adgroup_Get(campaignGK, null);

                foreach (Oltp.AdgroupRow a in t)
                    L.Add(new Models.AdgroupRowModel() { AdgroupGK = a.GK, AdgroupName = a.Name });
            }

            return PartialView("TableAdgroups", L);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult EditCampaign(long campaignGK)
        {
            Models.CampaignModel m = new Models.CampaignModel();

            using (var client = new OltpLogicClient(null))
            {
                m.Campaign = client.Service.Campaign_GetSingle(campaignGK)[0];


                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_campaign_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Campaign);
                    if (is_campaign_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = m.Campaign.Segment1; break;
                            case 2: value = m.Campaign.Segment2; break;
                            case 3: value = m.Campaign.Segment3; break;
                            case 4: value = m.Campaign.Segment4; break;
                            case 5: value = m.Campaign.Segment5; break;
                            default: value = m.Campaign.Segment1; break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }

                DataTable t = client.Service.CampaignTargets_Get(acc_id, campaignGK);
                if (t.Rows.Count > 0)
                {
                    m.Target_Customer = t.Rows[0]["CPA_new_users"] == DBNull.Value ? null : (double?)t.Rows[0]["CPA_new_users"];
                    m.Target_Depositor = t.Rows[0]["CPA_new_activations"] == DBNull.Value ? null : (double?)t.Rows[0]["CPA_new_activations"];
                }
            }


            return PartialView("CampaignDetails", m);

        }


        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditCampaign(long campaignGK, FormCollection coll)
        {
            Oltp.CampaignDataTable campaigns;
            using (var client = new OltpLogicClient(null))
            {
                campaigns = client.Service.Campaign_GetSingle(campaignGK);

                foreach (string key in coll.Keys)
                {
                    if (key.Contains("campaignSegmentValue_"))
                    {
                        string segment_id = key.Split('_')[1];
                        int segmentID = int.Parse(segment_id);
                        int segmentValue = int.Parse(coll[key]);
                        switch (segmentID)
                        {
                            case 1: campaigns[0].Segment1 = segmentValue; break;
                            case 2: campaigns[0].Segment2 = segmentValue; break;
                            case 3: campaigns[0].Segment3 = segmentValue; break;
                            case 4: campaigns[0].Segment4 = segmentValue; break;
                            case 5: campaigns[0].Segment5 = segmentValue; break;
                            default: break;
                        }
                    }
                }
                
                client.Service.Campaign_Save(campaigns, false);

                double? target1, target2;
                if (coll["Target1"].Equals(""))
                    target1 = null;
                else
                    target1 = double.Parse(coll["Target1"]);

                if (coll["Target2"].Equals(""))
                    target2 = null;
                else
                    target2 = double.Parse(coll["Target2"]);
                
                DataTable t = client.Service.CampaignTargets_Get(acc_id, campaignGK);
                DataRow r;
                
                if (t.Rows.Count > 0)
                    r = t.Rows[0];
                else
                    r = t.NewRow();

                r["CampaignGK"] = campaignGK;
                r["AdgroupGK"] = -1;
                if (target1 == null)
                    r["CPA_new_users"] = DBNull.Value;
                else
                    r["CPA_new_users"] = target1;

                if (target2 == null)
                    r["CPA_new_activations"] = DBNull.Value;
                else
                    r["CPA_new_activations"] = target2;

                if (t.Rows.Count > 0 && target1 == null && target2 == null)
                    r.Delete();
                else if (t.Rows.Count == 0 && (target1 != null || target2 != null))
                {
                    t.Rows.Add(r);
                }

                client.Service.CampaignTargets_Save(acc_id, t);                    
            }

            return Content("OK");
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult EditAdgroup(long adgroupGK)
        {
            Models.AdgroupModel m = new Models.AdgroupModel();

            using (var client = new OltpLogicClient(null))
            {
                m.Adgroup = client.Service.Adgroup_GetSingle(adgroupGK)[0];


                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_adgroup_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Adgroup);
                    if (is_adgroup_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = m.Adgroup.Segment1; break;
                            case 2: value = m.Adgroup.Segment2; break;
                            case 3: value = m.Adgroup.Segment3; break;
                            case 4: value = m.Adgroup.Segment4; break;
                            case 5: value = m.Adgroup.Segment5; break;
                            default: value = m.Adgroup.Segment1; break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }

                Oltp.AdgroupKeywordDataTable k = client.Service.AdgroupKeyword_Get(adgroupGK);
                foreach (Oltp.AdgroupKeywordRow r in k)
                {
                    Models.AdgroupKeywordModel m1 = new Models.AdgroupKeywordModel();
                    m1.DestinationURL = r.DestinationUrlDisplay;
                    m1.KeywordGK = r.KeywordGK;
                    m1.KeywordName = r.KeywordDisplay;
                    m1.MatchType = r.MatchTypeDisplay;
                    m.Keywords.Add(m1);
                }

                Oltp.AdgroupCreativeDataTable c = client.Service.AdgroupCreative_Get(adgroupGK);
                foreach (Oltp.AdgroupCreativeRow r in c)
                {
                    Models.AdgroupCreativeModel m1 = new Models.AdgroupCreativeModel();
                    m1.AdgroupCreativeGK = r.AdgroupCreativeGK;
                    m1.CreativeGK = r.CreativeGK;
                    m1.Desc1 = r.Desc1;
                    m1.Desc2 = r.Desc2;
                    m1.DestinationURL = r.DestinationURL;
                    m1.DisplayURL = r.DisplayURL;
                    m1.Title = r.Title;

                    foreach (Oltp.SegmentRow segment in segments)
                    {
                        bool is_adgroupcreative_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.AdgroupCreative);
                        if (is_adgroupcreative_segment)
                        {
                            Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                            long value;
                            switch (segment.SegmentID)
                            {
                                case 1: value = r.Segment1; break;
                                case 2: value = r.Segment2; break;
                                case 3: value = r.Segment3; break;
                                case 4: value = r.Segment4; break;
                                case 5: value = r.Segment5; break;
                                case 999: value = r.PageGK; break;
                                default: value = r.Segment1; break;
                            }
                            m1.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                        }
                    }

                    m.Creatives.Add(m1);

                }
            }


            return PartialView("AdgroupDetails", m);

        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditAdgroup(long adgroupGK, FormCollection coll)
        {
            Oltp.AdgroupDataTable adgroups;
            using (var client = new OltpLogicClient(null))
            {
                adgroups = client.Service.Adgroup_GetSingle(adgroupGK);

                foreach (string key in coll.Keys)
                {
                    if (key.Contains("adgroupSegmentValue_"))
                    {
                        string segment_id = key.Split('_')[1];
                        int segmentID = int.Parse(segment_id);
                        int segmentValue = int.Parse(coll[key]);
                        switch (segmentID)
                        {
                            case 1: adgroups[0].Segment1 = segmentValue; break;
                            case 2: adgroups[0].Segment2 = segmentValue; break;
                            case 3: adgroups[0].Segment3 = segmentValue; break;
                            case 4: adgroups[0].Segment4 = segmentValue; break;
                            case 5: adgroups[0].Segment5 = segmentValue; break;
                            default: break;
                        }
                    }
                }

                client.Service.Adgroup_Save(adgroups, false);

                Oltp.AdgroupCreativeDataTable adgroupcreatives = client.Service.AdgroupCreative_Get(adgroupGK);
                foreach (Oltp.AdgroupCreativeRow r in adgroupcreatives)
                {
                    foreach (string key in coll.Keys)
                    {
                        if (key.Contains("adgroupcreative" + r.AdgroupCreativeGK + "_SegmentValue_"))
                        {
                            string segment_id = key.Split('_')[2];
                            int segmentID = int.Parse(segment_id);
                            int segmentValue = int.Parse(coll[key]);
                            switch (segmentID)
                            {
                                case 1: r.Segment1 = segmentValue; break;
                                case 2: r.Segment2 = segmentValue; break;
                                case 3: r.Segment3 = segmentValue; break;
                                case 4: r.Segment4 = segmentValue; break;
                                case 5: r.Segment5 = segmentValue; break;
                                case 999: r.PageGK = segmentValue; break;
                                default: break;
                            }
                        }
                    }
                }
                client.Service.AdgroupCreative_Save(adgroupcreatives);
            }
            return Content("OK");
        }
    }
}
