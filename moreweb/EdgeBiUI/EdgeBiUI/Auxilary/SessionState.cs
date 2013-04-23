using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace EdgeBiUI.Auxilary
{
    public class AppState
    {
        public static string SessionID
        {
            get
            {
                if (HttpContext.Current.Session["session_id"] == null)
                    return null;
                else
                    return HttpContext.Current.Session["session_id"].ToString();
            }
            set
            {
                HttpContext.Current.Session["session_id"] = value;
            }
        }

        public static int AccountID
        {
            get
            {
                if (HttpContext.Current.Session["acc_id"] == null)
                    return 0;
                else
                    return (int)HttpContext.Current.Session["acc_id"];
            }
            set
            {
                HttpContext.Current.Session["acc_id"] = value;
            }
        }

    }
}