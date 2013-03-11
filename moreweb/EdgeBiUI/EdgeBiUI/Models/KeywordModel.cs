using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class KeywordModel
    {
        public Oltp.KeywordRow Keyword { get; set; }
        public List<AssociationRowModel> Associations { get; set; }
        public KeywordModel()
        {
            Associations = new List<AssociationRowModel>();
        }
    }

}