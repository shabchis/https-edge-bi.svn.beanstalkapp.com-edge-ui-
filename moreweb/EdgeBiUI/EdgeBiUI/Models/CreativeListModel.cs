using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using Easynet.Edge.UI.Data;

namespace EdgeBiUI.Models
{
    public class CreativeListModel
    {
        public List<Oltp.CreativeRow> Creatives { get; set; }

        public CreativeListModel()
        {
            Creatives = new List<Oltp.CreativeRow>();
        }
    }
}