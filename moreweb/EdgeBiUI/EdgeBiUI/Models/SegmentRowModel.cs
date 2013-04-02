using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public struct SegmentRowModel
    {
        public Oltp.SegmentRow SegmentRow { get; set; }
        public List<Oltp.SegmentValueRow> Values { get; set; }
        public long SelectedValue { get; set; }
    }
}