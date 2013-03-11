using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class KeywordsListModel
    {
        public List<Oltp.KeywordRow> Keywords { get; set; }

        public KeywordsListModel()
        {
            Keywords = new List<Oltp.KeywordRow>();
        }
    }
}