using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;
using EdgeBiUI.Auxilary;

namespace EdgeBiUI.Controllers
{
    public class HomeController : Controller
    {

        int acc_id = 10035;
        
        public ActionResult Index()
        {

            return View();

            

        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult AddNewSegmentValue(int segmentID, string newValue)
        {
            int newValueID = 0;
            using (var client = new OltpLogicClient(AppState.SessionID))
            {
                Oltp.SegmentValueDataTable t = client.Service.SegmentValue_Get(acc_id, segmentID);
                Oltp.SegmentValueRow r = t.NewSegmentValueRow();
                r.AccountID = acc_id;
                r.SegmentID = segmentID;
                r.Value = newValue;
                t.AddSegmentValueRow(r);

                Oltp.SegmentValueDataTable t2 = client.Service.SegmentValue_Save(t);

                Dictionary<int, string> oldcollection = t.ToDictionary(z => z.ValueID, z=>z.Value);
                Dictionary<int, string> newcollection = t2.ToDictionary(z => z.ValueID, z=>z.Value);

                newValueID = newcollection.Where(n => !oldcollection.ContainsKey(n.Key)).First().Key;
            }

            return Content(newValueID.ToString());
        }
    }
}
