using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Data;
using Easynet.Edge.UI.Client;

namespace EdgeBiUI.Controllers
{
    public class CreativesController : Controller
    {
        int acc_id = 10035;
        public ActionResult Index()
        {

            Models.CreativeListModel m = new Models.CreativeListModel();

            return View(m);
        }

        
        public PartialViewResult FindCreatives(string searchText)
        {
            Models.CreativeListModel m = new Models.CreativeListModel();

            using (var client = new OltpLogicClient(null))
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

            using (var client = new OltpLogicClient(null))
            {
                Oltp.CreativeRow creative = client.Service.Creative_GetSingle(creativeGK)[0];
                //client.Service.Creative_Get(
                m.Creative = creative;

                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, false);

                foreach (Oltp.SegmentRow r in segments)
                {
                    bool is_creative_segment = ((Auxilary.SegmentAssociationFlags)r.Association).HasFlag(Auxilary.SegmentAssociationFlags.AdgroupCreative);
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
            using (var client = new OltpLogicClient(null))
            {
                Oltp.UserDataTable x = client.Service.User_LoginBySessionID(null);

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

            using (var client = new OltpLogicClient(null))
            {
                client.Service.Creative_Save(creatives);
            }

            return Content("OK");
        }
    }
}
