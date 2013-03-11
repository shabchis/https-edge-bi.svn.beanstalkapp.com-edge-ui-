using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace EdgeBiUI.Models
{
    public class TrackersListModel
    {
        public Dictionary<int, string> Channels { get; set; }
        public List<Dictionary<int, string>> Segments { get; set; }

        public TrackersListModel()
        {
            Channels = new Dictionary<int, string>();
            Segments = new List<Dictionary<int, string>>();
        }

    }
}