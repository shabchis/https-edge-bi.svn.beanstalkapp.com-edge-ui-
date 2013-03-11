using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Data;
using Easynet.Edge.UI.Client;

namespace EdgeBiUI.Controllers
{
    public class KeywordsController : Controller
    {
        int acc_id = 10035;
        public ActionResult Index()
        {
            Models.KeywordsListModel m = new Models.KeywordsListModel();

            using (var client = new OltpLogicClient(null))
            {
                Oltp.KeywordDataTable keywords = client.Service.Keyword_Get(acc_id, true, "s%", true);

                foreach (Oltp.KeywordRow keyword in keywords)
                    m.Keywords.Add(keyword);
            }

            return View(m);
        }

        public ActionResult EditKeyword(long keywordGK)
        {
            Models.KeywordModel m = new Models.KeywordModel();

            using (var client = new OltpLogicClient(null))
            {
                m.Keyword = client.Service.Keyword_GetSingle(keywordGK)[0];

                Oltp.AdgroupDataTable keyword_adgroups = client.Service.Adgroup_GetByKeyword(keywordGK);
                Dictionary<int, Oltp.CampaignRow> campaings_dictionaty = client.Service.Campaign_GetIndividualCampaigns(keyword_adgroups.Select(f => f.CampaignGK).ToArray()).ToDictionary(f => f.GK, f => f);

                foreach (Oltp.AdgroupRow r in keyword_adgroups)
                {
                    m.Associations.Add(new Models.AssociationRowModel() { AdGroup = r, Campaign = campaings_dictionaty[(int)r.CampaignGK] });
                }

            }

            return PartialView("~/Views/Keywords/KeywordDetails.cshtml", m);
        }

    }
}
