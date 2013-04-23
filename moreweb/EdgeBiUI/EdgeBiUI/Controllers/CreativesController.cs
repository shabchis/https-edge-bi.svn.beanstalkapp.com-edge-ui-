using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Data;
using Easynet.Edge.UI.Client;
using EdgeBiUI.Auxilary;

namespace EdgeBiUI.Controllers
{
    public class CreativesController : Controller
    {
        //int acc_id = 10035;

        int acc_id = 0;
        string session_id = null;

        public CreativesController()
        {
            acc_id = AppState.AccountID;
            session_id = AppState.SessionID;
        }

        public ActionResult Index(int account, string session)
        {
            AppState.AccountID = account;
            AppState.SessionID = session == "" ? null : "";

            acc_id = AppState.AccountID;
            session_id = AppState.SessionID;

            Models.CreativeListModel m = new Models.CreativeListModel();
            return View(m);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult FindCreatives(string searchText)
        {
            Models.CreativeListModel m = new Models.CreativeListModel();

            using (var client = new OltpLogicClient(session_id))
            {
                Oltp.CreativeDataTable creatives = client.Service.Creative_Get(acc_id, searchText + "%", true);

                foreach (Oltp.CreativeRow creative in creatives)
                {
                    m.Creatives.Add(creative);
                }

                
            }

            

            return PartialView("Table", m);
        }
        
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditCreative(long creativeGK)
        {
            Models.CreativeModel m = new Models.CreativeModel();

            using (var client = new OltpLogicClient(session_id))
            {
                Oltp.CreativeRow creative = client.Service.Creative_GetSingle(creativeGK)[0];
                //client.Service.Creative_Get(
                m.Creative = creative;

                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, false);

                foreach (Oltp.SegmentRow r in segments)
                {
                    bool is_creative_segment = ((Auxilary.SegmentAssociationFlags)r.Association).HasFlag(Auxilary.SegmentAssociationFlags.Creative);
                    if (is_creative_segment)
                    {
                        Oltp.SegmentValueDataTable values = client.Service.SegmentValue_Get(acc_id, r.SegmentID);
                        int value;
                        switch (r.SegmentID)
                        {
                            case 1: value = creative.Segment1; break;
                            case 2: value = creative.Segment2; break;
                            case 3: value = creative.Segment3; break;
                            case 4: value = creative.Segment4; break;
                            case 5: value = creative.Segment5; break;
                            default: value = creative.Segment1; break;
                        }
                        
                        
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = r, Values = values.ToList(), SelectedValue = value });
                    }
                }

                Oltp.AdgroupDataTable creative_adgroups = client.Service.Adgroup_GetByCreative(creativeGK);
                Dictionary<int, Oltp.CampaignRow> campaings_dictionaty = client.Service.Campaign_GetIndividualCampaigns(creative_adgroups.Select(f => f.CampaignGK).ToArray()).ToDictionary(f => f.GK, f => f);

                foreach (Oltp.AdgroupRow r in creative_adgroups)
                {
                    m.Associations.Add(new Models.AssociationRowModel() { AdGroup = r, Campaign = campaings_dictionaty[(int)r.CampaignGK] });
                }

                m.Creative = creative;
                
            }

            return PartialView("~/Views/Creatives/CreativeDetails.cshtml", m);
        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditCreative(long creativeGK, FormCollection coll)
        {
            Oltp.CreativeDataTable creatives;
            using (var client = new OltpLogicClient(session_id))
            {
                creatives = client.Service.Creative_GetSingle(creativeGK);
            }

            foreach (string key in coll.Keys)
            {
                if (key.Contains("creativeSegmentValue_"))
                {
                    string segment_id = key.Split('_')[1];
                    int segmentID = int.Parse(segment_id);
                    int segmentValue = int.Parse(coll[key]);
                    switch (segmentID)
                    {
                        case 1: creatives[0].Segment1 = segmentValue; break;
                        case 2: creatives[0].Segment2 = segmentValue; break;
                        case 3: creatives[0].Segment3 = segmentValue; break;
                        case 4: creatives[0].Segment4 = segmentValue; break;
                        case 5: creatives[0].Segment5 = segmentValue; break;
                        default: break;
                    }
                }
            }
            System.Data.DataTable t = creatives.GetChanges();

            using (var client = new OltpLogicClient(session_id))
            {
                client.Service.Creative_Save(creatives);
            }

            return Content("OK");
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditMultipleCreatives(string creativesGK)
        {
            List<long> CreativesGK = creativesGK.Split(',').Select(s => s.Length > 0 ? long.Parse(s) : 0).ToList();
            Models.MutliCreativeModel m = new Models.MutliCreativeModel();
            m.CreativesGK = creativesGK;

            using (var client = new OltpLogicClient(session_id))
            {
                foreach (long creativeGK in CreativesGK)
                {
                    Oltp.CreativeDataTable t = client.Service.Creative_GetSingle(creativeGK);
                    if (t.Count > 0)
                        m.Creatives.Add(t[0]);
                }

                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, false);

                foreach (Oltp.SegmentRow r in segments)
                {
                    bool is_creative_segment = ((Auxilary.SegmentAssociationFlags)r.Association).HasFlag(Auxilary.SegmentAssociationFlags.Creative);
                    if (is_creative_segment)
                    {
                        Oltp.SegmentValueDataTable values = client.Service.SegmentValue_Get(acc_id, r.SegmentID);
                        int value;
                        switch (r.SegmentID)
                        {
                            case 1: value = GetCommonValue(m.Creatives.Select(x => x.Segment1).ToList()); break;
                            case 2: value = GetCommonValue(m.Creatives.Select(x => x.Segment2).ToList()); break;
                            case 3: value = GetCommonValue(m.Creatives.Select(x => x.Segment3).ToList()); break;
                            case 4: value = GetCommonValue(m.Creatives.Select(x => x.Segment4).ToList()); break;
                            case 5: value = GetCommonValue(m.Creatives.Select(x => x.Segment5).ToList()); break;
                            default: value = GetCommonValue(m.Creatives.Select(x => x.Segment1).ToList()); break;
                        }

                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = r, Values = values.ToList(), SelectedValue = value });
                    }
                }
            }

            return PartialView("MultiCreativeDetails", m);
        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditMultipleCreatives(string creativesGK, FormCollection coll)
        {
            List<long> CreativesGK = creativesGK.Split(',').Select(s => s.Length > 0 ? long.Parse(s) : 0).ToList();

            using (var client = new OltpLogicClient(session_id))
            {
                Oltp.CreativeDataTable Creatives = new Oltp.CreativeDataTable();
                foreach (long creativeGK in CreativesGK)
                    Creatives.Merge(client.Service.Creative_GetSingle(creativeGK));

                foreach (string key in coll.Keys)
                {
                    if (key.Contains("creativeSegmentValueEdit_"))
                    {
                        if (coll[key] == "1")
                        {
                            string segment_id = key.Split('_')[1];
                            int segmentID = int.Parse(segment_id);
                            int segmentValue = int.Parse(coll["creativeSegmentValue_" + segment_id]);
                            if (segmentValue != -100)
                            {
                                switch (segmentID)
                                {
                                    case 1: Creatives.ToList().ForEach(x => x.Segment1 = segmentValue); break;
                                    case 2: Creatives.ToList().ForEach(x => x.Segment2 = segmentValue); break;
                                    case 3: Creatives.ToList().ForEach(x => x.Segment3 = segmentValue); break;
                                    case 4: Creatives.ToList().ForEach(x => x.Segment4 = segmentValue); break;
                                    case 5: Creatives.ToList().ForEach(x => x.Segment5 = segmentValue); break;
                                    default: break;
                                }
                            }
                        }
                    }
                }

                client.Service.Creative_Save(Creatives);
            }

            return Content("OK");
        }

        public int GetCommonValue(List<int> vals)
        {
            int y = vals[0];
            bool a = true;
            vals.ForEach(x => { a = a && (x == y); y = x; });
            if (a)
                return y;
            else
                return -100;
        }
    }
}
