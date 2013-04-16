using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class CreativeModel
    {
        public Oltp.CreativeRow Creative { get; set; }
        public List<SegmentRowModel> Segments { get; set; }
        public List<AssociationRowModel> Associations { get; set; }
        public CreativeModel()
        {
            Segments = new List<SegmentRowModel>();
            Associations = new List<AssociationRowModel>();
        }
    }

    public class MutliCreativeModel
    {
        public string CreativesGK { get; set; }
        public List<Oltp.CreativeRow> Creatives { get; set; }
        public List<SegmentRowModel> Segments { get; set; }

        public MutliCreativeModel()
        {
            Creatives = new List<Oltp.CreativeRow>();
            Segments = new List<SegmentRowModel>();
        }
    }

}