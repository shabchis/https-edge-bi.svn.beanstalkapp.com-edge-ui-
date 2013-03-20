using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class TrackersListModel
    {
        public Dictionary<int, string> Channels { get; set; }
        public List<SegmentRowModel> Segments { get; set; }
        public List<TrackerRowModel> Trackers { get; set; }
        
        public TrackersListModel()
        {
            Channels = new Dictionary<int, string>();
            Segments = new List<SegmentRowModel>();
            Trackers = new List<TrackerRowModel>();
        }

    }

    public struct TrackerRowModel
    {
        public long TrackerID { get; set; }
        public string Identifier { get; set; }
        public string TrackerName { get; set; }
        public string ChannelName { get; set; }
    }

}