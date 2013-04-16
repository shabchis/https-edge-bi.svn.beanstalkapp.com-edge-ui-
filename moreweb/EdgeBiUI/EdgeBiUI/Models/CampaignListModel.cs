using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class CampaignListModel
    {
        public Dictionary<int, string> Channels { get; set; }
        public Dictionary<int, string> Statuses { get; set; }
        public List<CampaignRowModel> Campaigns { get; set; }

        public CampaignListModel()
        {
            Channels = new Dictionary<int, string>();
            Statuses = new Dictionary<int, string>();
            Campaigns = new List<CampaignRowModel>();
        }

    }

    public class CampaignRowModel
    {
        public long CampaignGK { get; set; }
        public string CampaignName { get; set; }
        public string Status { get; set; }
        public string ChannelName { get; set; }
        public double? CPA1 { get; set; }
        public double? CPA2 { get; set; }
    }

    public struct AdgroupRowModel
    {
        public int AdgroupGK { get; set; }
        public string AdgroupName { get; set; }
    }

}