using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace EdgeBiUI.Auxilary
{
    public class Helpers
    {
        public static string GetShortDescription(string str, int len)
        {
            if (str.Length > len)
                return str.Substring(0, len) + "...";
            return str;
        }
    }
}