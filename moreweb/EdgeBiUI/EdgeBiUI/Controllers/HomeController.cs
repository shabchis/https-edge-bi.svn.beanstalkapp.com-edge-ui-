using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Controllers
{
    public class HomeController : Controller
    {
        //
        // GET: /Home/
        
        public ActionResult Index()
        {

            return View();

            using (var client = new OltpLogicClient(null))
            {
                int acc_id = 10035;
                Oltp.SegmentDataTable seg = client.Service.Segment_Get(acc_id, true);

                List<Oltp.SegmentRow> uy = seg.Where(z=>((EdgeBiUI.Auxilary.SegmentAssociationFlags)z.Association).HasFlag(EdgeBiUI.Auxilary.SegmentAssociationFlags.Creative)).ToList();

                Oltp.CreativeDataTable creatives = client.Service.Creative_Get(acc_id, "s%", true);

                foreach (Oltp.SegmentRow r in uy)
                {
                    //name
                    string name = r.Name;
                    //values
                    client.Service.SegmentValue_Get(acc_id, r.SegmentID);
                    //selected value
                    int val;
                    switch (r.SegmentID)
                    {
                        case 1: val = creatives[0].Segment1; break;
                        default: val = 0; break;
                    }
                }


                creatives[0].Segment1 = 12;
                client.Service.Creative_Save(creatives);
                //client.SegmentValue_Get(acc_id, uy[0])

                

                

                return null;
            }

        }

    }
}
