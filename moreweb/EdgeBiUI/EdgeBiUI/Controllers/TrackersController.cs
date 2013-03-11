using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Controllers
{
    public class TrackersController : Controller
    {
        int acc_id = 10035;

        public ActionResult Index()
        {
            Models.TrackersListModel m = new Models.TrackersListModel();

            using (var client = new OltpLogicClient(null))
            {
                // Load Channels
                Oltp.ChannelDataTable channels = client.Service.Channel_Get();
                m.Channels = channels.ToDictionary(c => c.ID, c => c.DisplayName);


                // Load Segments
                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);

                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_tracker_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Gateyway);
                    if (is_tracker_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        Dictionary<int, string> segment_values_dic = segment_values.ToDictionary(s => s.ValueID, s => s.Value);
                        m.Segments.Add(segment_values_dic);
                    }
                }

                //EdgeBIServer.Oltp.GatewayDataTable t = client.Gateway_GetGateways(acc_id, null, 

            }
            return View(m);
        }

    }
}
