using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Data;
using Easynet.Edge.UI.Client;
using Easynet.Edge.UI.Data;

namespace ConsoleApplication1
{
	class Program
	{
		static void Main(string[] args)
		{
			using (var client = new OltpLogicClient(null))
			{
				// To be retrieved from iFrame URL parameter.
				// Validation is currently disabled in MorWebOTLP database
				//string sessionID = null;

				// Logging in is required otherwise all other service operations will fail (comment out these lines to see how)
				//Oltp.UserDataTable user = client.Service.User_LoginBySessionID(sessionID);
				Console.WriteLine("Logged in as {0}", client.CurrentUser.Name);

				// Get all campaigns for every account
				Oltp.AccountDataTable accounts = client.Service.Account_Get();
				foreach (Oltp.AccountRow account in accounts.Rows)
				{
					Console.WriteLine();
					Console.WriteLine("Campaigns for account {0} - {1}:", account.ID, account.Name);
					Console.WriteLine("--------------------------------------------");
					Oltp.CampaignDataTable campaigns = client.Service.Campaign_Get(account.ID, null, null, null, false);
					foreach (Oltp.CampaignRow campaign in campaigns.Rows)
					{
						Console.WriteLine("{0} - {1}", campaign.GK, campaign.Name);
					}
				}

				Console.ReadLine();
			}
		}
	}
}
