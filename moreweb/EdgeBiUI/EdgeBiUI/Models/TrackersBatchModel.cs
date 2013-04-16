using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class TrackersBatchModel
    {
        public List<SegmentRowModel> Segments { get; set; }
        public Dictionary<int, string> Channels { get; set; }
        public Dictionary<long, string> LandingPages { get; set; }

        public TrackersBatchModel()
        {
            Segments = new List<SegmentRowModel>();
            Channels = new Dictionary<int, string>();
            LandingPages = new Dictionary<long, string>();
        }
    }
}