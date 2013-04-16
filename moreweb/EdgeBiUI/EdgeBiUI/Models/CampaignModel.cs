using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class CampaignModel
    {
        public Oltp.CampaignRow Campaign { get; set; }
        public List<SegmentRowModel> Segments { get; set; }
        public double? Target_Customer { get; set; }
        public double? Target_Depositor { get; set; }

        public CampaignModel()
        {
            Segments = new List<SegmentRowModel>();
            Target_Depositor = null;
            Target_Customer = null;
        }
    }

    public class MultiCampaignModel
    {
        public string CampaignsGK { get; set; }
        public List<Oltp.CampaignRow> Campaigns { get; set; }        
        public List<SegmentRowModel> Segments { get; set; }
        public double? Target_Customer { get; set; }
        public double? Target_Depositor { get; set; }

        public MultiCampaignModel()
        {
            Segments = new List<SegmentRowModel>();
            Target_Depositor = null;
            Target_Customer = null;
        }
    }
}