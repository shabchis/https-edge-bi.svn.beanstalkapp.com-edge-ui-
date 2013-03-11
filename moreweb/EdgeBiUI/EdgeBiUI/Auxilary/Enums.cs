using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace EdgeBiUI.Auxilary
{
    [Flags]
    public enum SegmentAssociationFlags
    {
        Keyword = 0x01,
        Creative = 0x02,
        Site = 0x04,
        Campaign = 0x08,
        Adgroup = 0x10,
        AdgroupKeyword = 0x20,
        AdgroupCreative = 0x40,
        AdgroupSite = 0x80,
        Gateyway = 0x100
    }
}