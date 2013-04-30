using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;
using System.Data;
using EdgeBiUI.Auxilary;

namespace EdgeBiUI.Controllers
{
    public class CampaignsController : Controller
    {
        int acc_id = 0;
        string session_id = null;

        public CampaignsController()
        {
            acc_id = AppState.AccountID;
            session_id = AppState.SessionID;
        }

        public ActionResult Index(int account, string session)
        {
            AppState.AccountID = account;
            AppState.SessionID = session;

            acc_id = AppState.AccountID;
            session_id = AppState.SessionID;

            Models.CampaignListModel m = new Models.CampaignListModel();
            using (var client = new OltpLogicClient(session_id))
            {
                //Oltp.CampaignDataTable t = client.Service.Campaign_Get(acc_id, null, null, null, false);
                m.Statuses = client.Service.CampaignStatus_Get().ToDictionary(x => x.ID, x => x.Name);
                m.Channels = client.Service.Channel_Get().ToDictionary(h => h.ID, h => h.DisplayName);
                
                //foreach(Oltp.CampaignRow c in t)
                  //  m.Campaigns.Add(new Models.CampaignRowModel() { CampaignGK = c.GK, CampaignName = c.Name, Status = m.Statuses[c.StatusID], ChannelName = m.Channels[c.ChannelID] });
            }

            return View(m);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult Find(FormCollection colls)
        {
            Models.CampaignListModel m = new Models.CampaignListModel();
            using (var client = new OltpLogicClient(session_id))
            {
                m.Statuses = client.Service.CampaignStatus_Get().ToDictionary(x => x.ID, x => x.Name);
                m.Channels = client.Service.Channel_Get().ToDictionary(h => h.ID, h => h.DisplayName);
                
                int? channelID = colls["Channel"] == "0" ? null : (int?)int.Parse(colls["Channel"]);
                int? statusID = colls["Status"] == "0" ? null : (int?)int.Parse(colls["Status"]);
                string textToSearch = colls["searchText"].Trim().Equals("") ? null : colls["searchText"].Trim()+"%";
                bool filterByAdgroup = colls["typeOfSearch"] == "adgroup";

                Oltp.CampaignDataTable t = client.Service.Campaign_Get(acc_id, channelID, statusID, textToSearch, filterByAdgroup);
                foreach (Oltp.CampaignRow c in t)
                    m.Campaigns.Add(new Models.CampaignRowModel() { CampaignGK = c.GK, CampaignName = c.Name, Status = m.Statuses[c.StatusID], ChannelName = m.Channels[c.ChannelID] });

                DataTable targets = client.Service.CampaignTargets_Get(acc_id, null);
                Dictionary<long, Models.CampaignRowModel> dic = m.Campaigns.ToDictionary(q => q.CampaignGK, q => q);

                foreach (DataRow r in targets.Rows)
                {
                    long campaignGK = (long)(int)r["CampaignGK"];
                    if (dic.ContainsKey(campaignGK))
                    {
                        dic[campaignGK].CPA1 = r["CPA_new_users"] == DBNull.Value ? null : (double?)r["CPA_new_users"];
                        dic[campaignGK].CPA2 = r["CPA_new_activations"] == DBNull.Value ? null : (double?)r["CPA_new_activations"];
                    }
                }

            }

            return PartialView("Table", m.Campaigns);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult GetAdgroupsForCampaign(long campaignGK)
        {
            List<Models.AdgroupRowModel> L = new List<Models.AdgroupRowModel>();
            using (var client = new OltpLogicClient(session_id))
            {
                Oltp.AdgroupDataTable t = client.Service.Adgroup_Get(campaignGK, null);

                foreach (Oltp.AdgroupRow a in t)
                    L.Add(new Models.AdgroupRowModel() { AdgroupGK = a.GK, AdgroupName = a.Name });
            }

            return PartialView("TableAdgroups", L);
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult EditCampaign(long campaignGK)
        {
            Models.CampaignModel m = new Models.CampaignModel();

            using (var client = new OltpLogicClient(session_id))
            {
                m.Campaign = client.Service.Campaign_GetSingle(campaignGK)[0];


                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_campaign_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Campaign);
                    if (is_campaign_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = m.Campaign.Segment1; break;
                            case 2: value = m.Campaign.Segment2; break;
                            case 3: value = m.Campaign.Segment3; break;
                            case 4: value = m.Campaign.Segment4; break;
                            case 5: value = m.Campaign.Segment5; break;
                            default: value = m.Campaign.Segment1; break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }

                DataTable t = client.Service.CampaignTargets_Get(acc_id, campaignGK);
                if (t.Rows.Count > 0)
                {
                    m.Target_Customer = t.Rows[0]["CPA_new_users"] == DBNull.Value ? null : (double?)t.Rows[0]["CPA_new_users"];
                    m.Target_Depositor = t.Rows[0]["CPA_new_activations"] == DBNull.Value ? null : (double?)t.Rows[0]["CPA_new_activations"];
                }
            }


            return PartialView("CampaignDetails", m);

        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult SaveTargets(FormCollection coll)
        {
            using (var client = new OltpLogicClient(session_id))
            {
                string a1 = coll["campaignsGK"];
                Dictionary<long, long> campaignsGK = a1.Split(',').Select(x => long.Parse(x)).ToDictionary(d=>d, d=>d);
                DataTable targetsTable = client.Service.CampaignTargets_Get(acc_id, null);
                
                List<DataRow> RowsToRemove = new List<DataRow>();
                foreach(DataRow r in targetsTable.Rows)
                {
                    long gk = long.Parse(r["CampaignGK"].ToString());
                    if (!campaignsGK.ContainsKey(gk))
                        RowsToRemove.Add(r);
                }
                RowsToRemove.ForEach(x => targetsTable.Rows.Remove(x));

                List<DataRow> RowsToAdd = new List<DataRow>();
                foreach (long gk in campaignsGK.Keys)
                {
                    bool f = false;
                    foreach (DataRow r in targetsTable.Rows)
                        if (long.Parse(r["CampaignGK"].ToString()) == gk)
                            f = true;

                    if (!f)
                    {
                        DataRow r = targetsTable.NewRow();
                        r["CampaignGK"] = gk;
                        r["AdgroupGK"] = -1;
                        RowsToAdd.Add(r);
                    }
                }

                RowsToAdd.ForEach(x => targetsTable.Rows.Add(x));

                foreach (DataRow r in targetsTable.Rows)
                {
                    long gk = long.Parse(r["CampaignGK"].ToString());
                    double? target1, target2;

                    if (coll["campaigntarget_" + gk + "_CPA1"].Equals(""))
                        target1 = null;
                    else
                        target1 = double.Parse(coll["campaigntarget_" + gk + "_CPA1"]);

                    if (coll["campaigntarget_" + gk + "_CPA2"].Equals(""))
                        target2 = null;
                    else
                        target2 = double.Parse(coll["campaigntarget_" + gk + "_CPA2"]);

                    if (target1 == null)
                        r["CPA_new_users"] = DBNull.Value;
                    else
                        r["CPA_new_users"] = target1;

                    if (target2 == null)
                        r["CPA_new_activations"] = DBNull.Value;
                    else
                        r["CPA_new_activations"] = target2;
                }


                client.Service.CampaignTargets_Save(acc_id, targetsTable);
            }

            return Content("OK");
        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditCampaign(long campaignGK, FormCollection coll)
        {
            Oltp.CampaignDataTable campaigns;
            using (var client = new OltpLogicClient(session_id))
            {
                campaigns = client.Service.Campaign_GetSingle(campaignGK);

                foreach (string key in coll.Keys)
                {
                    if (key.Contains("campaignSegmentValue_"))
                    {
                        string segment_id = key.Split('_')[1];
                        int segmentID = int.Parse(segment_id);
                        int segmentValue = int.Parse(coll[key]);
                        switch (segmentID)
                        {
                            case 1: campaigns[0].Segment1 = segmentValue; break;
                            case 2: campaigns[0].Segment2 = segmentValue; break;
                            case 3: campaigns[0].Segment3 = segmentValue; break;
                            case 4: campaigns[0].Segment4 = segmentValue; break;
                            case 5: campaigns[0].Segment5 = segmentValue; break;
                            default: break;
                        }
                    }
                }
                
                client.Service.Campaign_Save(campaigns, false);

                double? target1, target2;
                if (coll["Target1"].Equals(""))
                    target1 = null;
                else
                    target1 = double.Parse(coll["Target1"]);

                if (coll["Target2"].Equals(""))
                    target2 = null;
                else
                    target2 = double.Parse(coll["Target2"]);
                
                DataTable t = client.Service.CampaignTargets_Get(acc_id, campaignGK);
                DataRow r;
                
                if (t.Rows.Count > 0)
                    r = t.Rows[0];
                else
                    r = t.NewRow();

                r["CampaignGK"] = campaignGK;
                r["AdgroupGK"] = -1;
                if (target1 == null)
                    r["CPA_new_users"] = DBNull.Value;
                else
                    r["CPA_new_users"] = target1;

                if (target2 == null)
                    r["CPA_new_activations"] = DBNull.Value;
                else
                    r["CPA_new_activations"] = target2;

                if (t.Rows.Count > 0 && target1 == null && target2 == null)
                    r.Delete();
                else if (t.Rows.Count == 0 && (target1 != null || target2 != null))
                {
                    t.Rows.Add(r);
                }

                client.Service.CampaignTargets_Save(acc_id, t);                    
            }

            return Content("OK");
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditMultipleCampaign(string campaignsGK)
        {
            List<long> CampaingsGK = campaignsGK.Split(',').Select(s => s.Length > 0 ? long.Parse(s) : 0).ToList();
            Models.MultiCampaignModel m = new Models.MultiCampaignModel();
            m.CampaignsGK = campaignsGK;
            using (var client = new OltpLogicClient(session_id))
            {
                m.Campaigns = client.Service.Campaign_GetIndividualCampaigns(CampaingsGK.ToArray()).ToList();

                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_campaign_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Campaign);
                    if (is_campaign_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = GetCommonValue(m.Campaigns.Select(x=>x.Segment1).ToList()); break;
                            case 2: value = GetCommonValue(m.Campaigns.Select(x => x.Segment2).ToList()); break;
                            case 3: value = GetCommonValue(m.Campaigns.Select(x => x.Segment3).ToList()); break;
                            case 4: value = GetCommonValue(m.Campaigns.Select(x => x.Segment4).ToList()); break;
                            case 5: value = GetCommonValue(m.Campaigns.Select(x => x.Segment5).ToList()); break;
                            default: value = GetCommonValue(m.Campaigns.Select(x => x.Segment1).ToList()); break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }
            }


            return PartialView("MultiCampaignDetails", m); 
        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditMultipleCampaign(string campaignsGK, FormCollection coll)
        {
            Oltp.CampaignDataTable campaigns;
            List<long> CampaingsGK = campaignsGK.Split(',').Select(s => s.Length > 0 ? long.Parse(s) : 0).ToList();

            using (var client = new OltpLogicClient(session_id))
            {
                campaigns = client.Service.Campaign_GetIndividualCampaigns(CampaingsGK.ToArray());
                foreach (string key in coll.Keys)
                {
                    if (key.Contains("campaignSegmentValueEdit_"))
                    {
                        if (coll[key] == "1")
                        {
                            string segment_id = key.Split('_')[1];
                            int segmentID = int.Parse(segment_id);
                            int segmentValue = int.Parse(coll["campaignSegmentValue_" + segment_id]);
                            if (segmentValue != -100)
                            {
                                switch (segmentID)
                                {
                                    case 1: campaigns.ToList().ForEach(x=>x.Segment1 = segmentValue); break;
                                    case 2: campaigns.ToList().ForEach(x => x.Segment2 = segmentValue); break;
                                    case 3: campaigns.ToList().ForEach(x => x.Segment3 = segmentValue); break;
                                    case 4: campaigns.ToList().ForEach(x => x.Segment4 = segmentValue); break;
                                    case 5: campaigns.ToList().ForEach(x => x.Segment5 = segmentValue); break;
                                    default: break;
                                }
                            }
                        }
                    }
                }

                client.Service.Campaign_Save(campaigns, false);

                double? target1, target2;
                if (coll["Target1"] == null || coll["Target1"].Equals(""))
                    target1 = null;
                else
                    target1 = double.Parse(coll["Target1"]);

                if (coll["Target2"] == null || coll["Target2"].Equals(""))
                    target2 = null;
                else
                    target2 = double.Parse(coll["Target2"]);

                bool editTarget1 = coll["EditTarget1"] == "1";
                bool editTarget2 = coll["EditTarget2"] == "1";

                if (editTarget1 || editTarget1)
                {
                    DataTable t = client.Service.CampaignTargets_Get(acc_id, null);
                    List<DataRow> RowsToRemove = new List<DataRow>();
                    foreach (DataRow r in t.Rows)
                    {
                        if (!CampaingsGK.Contains((long)(int)r["CampaignGK"]))
                            RowsToRemove.Add(r);
                        else
                        {
                            if (editTarget1)
                            {
                                if (target1 != null)
                                    r["CPA_new_users"] = target1;
                                else
                                    r["CPA_new_users"] = DBNull.Value;
                            }
                            if (editTarget2)
                            {
                                if (target2 != null)
                                    r["CPA_new_activations"] = target2;
                                else
                                    r["CPA_new_activations"] = DBNull.Value;
                            }
                        }
                    }
                    RowsToRemove.ForEach(x => t.Rows.Remove(x));

                    List<DataRow> RowsToAdd = new List<DataRow>();
                    foreach (Oltp.CampaignRow c in campaigns)
                    {
                        bool f = false;
                        foreach (DataRow r in t.Rows)
                            if ((long)(int)r["CampaignGK"] == c.GK)
                                f = true;

                        if (!f)
                        {
                            DataRow r = t.NewRow();
                            r["CampaignGK"] = c.GK;
                            r["AdgroupGK"] = -1;
                            if (editTarget1)
                            {
                                if (target1 != null)
                                    r["CPA_new_users"] = target1;
                                else
                                    r["CPA_new_users"] = DBNull.Value;
                            }
                            if (editTarget2)
                            {
                                if (target2 != null)
                                    r["CPA_new_activations"] = target2;
                                else
                                    r["CPA_new_activations"] = DBNull.Value;
                            }
                            RowsToAdd.Add(r);
                        }
                    }

                    RowsToAdd.ForEach(x => t.Rows.Add(x));

                    client.Service.CampaignTargets_Save(acc_id, t);
                }
            }

            return Content("OK");
        }


        public int GetCommonValue(List<int> vals)
        {
            int y = vals[0];
            bool a = true;
            vals.ForEach(x => { a = a && (x == y); y = x; });
            if (a)
                return y;
            else
                return -100;
        }
        


        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult EditAdgroup(long adgroupGK)
        {
            Models.AdgroupModel m = new Models.AdgroupModel();

            using (var client = new OltpLogicClient(session_id))
            {
                m.Adgroup = client.Service.Adgroup_GetSingle(adgroupGK)[0];


                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_adgroup_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Adgroup);
                    if (is_adgroup_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = m.Adgroup.Segment1; break;
                            case 2: value = m.Adgroup.Segment2; break;
                            case 3: value = m.Adgroup.Segment3; break;
                            case 4: value = m.Adgroup.Segment4; break;
                            case 5: value = m.Adgroup.Segment5; break;
                            default: value = m.Adgroup.Segment1; break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }

                Oltp.AdgroupKeywordDataTable k = client.Service.AdgroupKeyword_Get(adgroupGK);
                foreach (Oltp.AdgroupKeywordRow r in k)
                {
                    Models.AdgroupKeywordModel m1 = new Models.AdgroupKeywordModel();
                    m1.DestinationURL = r.DestinationUrlDisplay;
                    m1.KeywordGK = r.KeywordGK;
                    m1.KeywordName = r.KeywordDisplay;
                    m1.MatchType = r.MatchTypeDisplay;
                    m.Keywords.Add(m1);
                }

                Oltp.AdgroupCreativeDataTable c = client.Service.AdgroupCreative_Get(adgroupGK);
                foreach (Oltp.AdgroupCreativeRow r in c)
                {
                    Models.AdgroupCreativeModel m1 = new Models.AdgroupCreativeModel();
                    m1.AdgroupCreativeGK = r.AdgroupCreativeGK;
                    m1.CreativeGK = r.CreativeGK;
                    m1.Desc1 = r.Desc1;
                    m1.Desc2 = r.Desc2;
                    m1.DestinationURL = r.DestinationURL;
                    m1.DisplayURL = r.DisplayURL;
                    m1.Title = r.Title;

                    foreach (Oltp.SegmentRow segment in segments)
                    {
                        bool is_adgroupcreative_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.AdgroupCreative);
                        if (is_adgroupcreative_segment)
                        {
                            Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                            long value;
                            switch (segment.SegmentID)
                            {
                                case 1: value = r.Segment1; break;
                                case 2: value = r.Segment2; break;
                                case 3: value = r.Segment3; break;
                                case 4: value = r.Segment4; break;
                                case 5: value = r.Segment5; break;
                                case 999: value = r.PageGK; break;
                                default: value = r.Segment1; break;
                            }
                            m1.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                        }
                    }

                    m.Creatives.Add(m1);

                }
            }


            return PartialView("AdgroupDetails", m);

        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditAdgroup(long adgroupGK, FormCollection coll)
        {
            Oltp.AdgroupDataTable adgroups;
            using (var client = new OltpLogicClient(session_id))
            {
                adgroups = client.Service.Adgroup_GetSingle(adgroupGK);

                foreach (string key in coll.Keys)
                {
                    if (key.Contains("adgroupSegmentValue_"))
                    {
                        string segment_id = key.Split('_')[1];
                        int segmentID = int.Parse(segment_id);
                        int segmentValue = int.Parse(coll[key]);
                        switch (segmentID)
                        {
                            case 1: adgroups[0].Segment1 = segmentValue; break;
                            case 2: adgroups[0].Segment2 = segmentValue; break;
                            case 3: adgroups[0].Segment3 = segmentValue; break;
                            case 4: adgroups[0].Segment4 = segmentValue; break;
                            case 5: adgroups[0].Segment5 = segmentValue; break;
                            default: break;
                        }
                    }
                }

                client.Service.Adgroup_Save(adgroups, false);

                Oltp.AdgroupCreativeDataTable adgroupcreatives = client.Service.AdgroupCreative_Get(adgroupGK);
                foreach (Oltp.AdgroupCreativeRow r in adgroupcreatives)
                {
                    foreach (string key in coll.Keys)
                    {
                        if (key.Contains("adgroupcreative" + r.AdgroupCreativeGK + "_SegmentValue_"))
                        {
                            string segment_id = key.Split('_')[2];
                            int segmentID = int.Parse(segment_id);
                            int segmentValue = int.Parse(coll[key]);
                            switch (segmentID)
                            {
                                case 1: r.Segment1 = segmentValue; break;
                                case 2: r.Segment2 = segmentValue; break;
                                case 3: r.Segment3 = segmentValue; break;
                                case 4: r.Segment4 = segmentValue; break;
                                case 5: r.Segment5 = segmentValue; break;
                                case 999: r.PageGK = segmentValue; break;
                                default: break;
                            }
                        }
                    }
                }
                client.Service.AdgroupCreative_Save(adgroupcreatives);
            }
            return Content("OK");
        }

        [OutputCache(Duration = 0, NoStore = true)]
        public PartialViewResult EditMultipleAdgroups(string adgroupsGK)
        {
            Oltp.AdgroupDataTable adgroups;
            List<long> AdgroupsGK = adgroupsGK.Split(',').Select(s => s.Length > 0 ? long.Parse(s) : 0).ToList();
            Models.MultipleAdgroupModel m = new Models.MultipleAdgroupModel();
            m.AdgroupsGK = adgroupsGK;

            using (var client = new OltpLogicClient(session_id))
            {
                foreach (long adgroupGK in AdgroupsGK)
                {
                    Oltp.AdgroupDataTable t = client.Service.Adgroup_GetSingle(adgroupGK);
                    if (t.Count > 0)
                        m.Adgroups.Add(t[0]);
                }


                Oltp.SegmentDataTable segments = client.Service.Segment_Get(acc_id, true);
                foreach (Oltp.SegmentRow segment in segments)
                {
                    bool is_adgroup_segment = ((Auxilary.SegmentAssociationFlags)segment.Association).HasFlag(Auxilary.SegmentAssociationFlags.Adgroup);
                    if (is_adgroup_segment)
                    {
                        Oltp.SegmentValueDataTable segment_values = client.Service.SegmentValue_Get(acc_id, segment.SegmentID);
                        int value;
                        switch (segment.SegmentID)
                        {
                            case 1: value = GetCommonValue(m.Adgroups.Select(x=>x.Segment1).ToList()); break;
                            case 2: value = GetCommonValue(m.Adgroups.Select(x => x.Segment2).ToList()); break;
                            case 3: value = GetCommonValue(m.Adgroups.Select(x => x.Segment3).ToList()); break;
                            case 4: value = GetCommonValue(m.Adgroups.Select(x => x.Segment4).ToList()); break;
                            case 5: value = GetCommonValue(m.Adgroups.Select(x => x.Segment5).ToList()); break;
                            default: value = GetCommonValue(m.Adgroups.Select(x => x.Segment1).ToList()); break;
                        }
                        m.Segments.Add(new Models.SegmentRowModel() { SegmentRow = segment, Values = segment_values.ToList(), SelectedValue = value });
                    }
                }
            }

            return PartialView("MultipleAdgroupDetails", m);
        }

        [HttpPost]
        [OutputCache(Duration = 0, NoStore = true)]
        public ActionResult EditMultipleAdgroups(string adgroupsGK, FormCollection coll)
        {
            List<long> AdgroupsGK = adgroupsGK.Split(',').Select(s => s.Length > 0 ? long.Parse(s) : 0).ToList();

            using (var client = new OltpLogicClient(session_id))
            {
                Oltp.AdgroupDataTable adgroups = new Oltp.AdgroupDataTable();
                foreach (long adgroupGK in AdgroupsGK)
                    adgroups.Merge(client.Service.Adgroup_GetSingle(adgroupGK));

                foreach (string key in coll.Keys)
                {
                    if (key.Contains("adgroupSegmentValueEdit_"))
                    {
                        if (coll[key] == "1")
                        {
                            string segment_id = key.Split('_')[1];
                            int segmentID = int.Parse(segment_id);
                            int segmentValue = int.Parse(coll["adgroupSegmentValue_" + segment_id]);
                            if (segmentValue != -100)
                            {
                                switch (segmentID)
                                {
                                    case 1: adgroups.ToList().ForEach(x => x.Segment1 = segmentValue); break;
                                    case 2: adgroups.ToList().ForEach(x => x.Segment2 = segmentValue); break;
                                    case 3: adgroups.ToList().ForEach(x => x.Segment3 = segmentValue); break;
                                    case 4: adgroups.ToList().ForEach(x => x.Segment4 = segmentValue); break;
                                    case 5: adgroups.ToList().ForEach(x => x.Segment5 = segmentValue); break;
                                    default: break;
                                }
                            }
                        }
                    }
                }

                client.Service.Adgroup_Save(adgroups, false);
            }

            return Content("OK");
        }
    }
}


