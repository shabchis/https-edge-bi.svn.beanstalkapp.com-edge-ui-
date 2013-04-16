using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class AdgroupModel
    {
        public Oltp.AdgroupRow Adgroup { get; set; }
        public List<SegmentRowModel> Segments { get; set; }
        public List<AdgroupKeywordModel> Keywords { get; set; }
        public List<AdgroupCreativeModel> Creatives { get; set; }

        public AdgroupModel()
        {
            Segments = new List<SegmentRowModel>();
            Keywords = new List<AdgroupKeywordModel>();
            Creatives = new List<AdgroupCreativeModel>();
        }
    }

    public struct AdgroupKeywordModel
    {
        public long KeywordGK;
        public string KeywordName;
        public string MatchType;
        public string DestinationURL;
    }

    public class AdgroupCreativeModel
    {
        public long AdgroupCreativeGK;
        public long CreativeGK;
        public string Title;
        public string Desc1;
        public string Desc2;
        public string DestinationURL;
        public string DisplayURL;
        public List<SegmentRowModel> Segments;

        public AdgroupCreativeModel()
        {
            Segments = new List<SegmentRowModel>();
        }
    }

    public class MultipleAdgroupModel
    {
        public string AdgroupsGK { get; set; }
        public List<Oltp.AdgroupRow> Adgroups { get; set; }
        public List<SegmentRowModel> Segments { get; set; }

        public MultipleAdgroupModel()
        {
            Segments = new List<SegmentRowModel>();
            Adgroups = new List<Oltp.AdgroupRow>();

        }
    }
}