using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

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

        public static ContentResult HandleSessionExpired()
        {
            return new ContentResult { Content = "<script type='text/javascript'>window.parent.handleSessionExpired();</script>" };
        }
    }
}