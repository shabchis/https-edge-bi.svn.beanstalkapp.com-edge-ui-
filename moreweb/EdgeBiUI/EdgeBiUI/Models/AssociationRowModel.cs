using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public struct AssociationRowModel
    {
        public Oltp.AdgroupRow AdGroup { get; set; }
        public Oltp.CampaignRow Campaign { get; set; }
    }
}