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
    public class KeywordsController : Controller
    {
        int acc_id = 0;
        string session_id = null;

        public KeywordsController()
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

            Models.KeywordsListModel m = new Models.KeywordsListModel();
            return View(m);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult FindKeywords(string searchText)
        {
            List<Oltp.KeywordRow> L = new List<Oltp.KeywordRow>();
            using (var client = new OltpLogicClient(session_id))
            {
                string str = searchText.Trim().Length > 0 ? searchText.Trim() + "*" : null;
                Oltp.KeywordDataTable keywords = client.Service.Keyword_Get(acc_id, true, str, true);

                foreach (Oltp.KeywordRow keyword in keywords)
                    L.Add(keyword);
            }

            return PartialView("Table", L);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditKeyword(long keywordGK)
        {
            Models.KeywordModel m = new Models.KeywordModel();

            using (var client = new OltpLogicClient(session_id))
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
