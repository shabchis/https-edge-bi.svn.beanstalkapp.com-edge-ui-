using System;
using System.Collections.Generic;
using System.IO;
using System.Runtime.Serialization;
using System.Timers;
using System.Xml.Serialization;
using Easynet.Edge.Core.Configuration;
using Easynet.Edge.Core.Data;
using Easynet.Edge.Core.Utilities;
using System.Data.SqlClient;
using System.Data;

namespace Easynet.Edge.BusinessObjects
{
	/// <summary>
	/// 
	/// </summary>
	public static class GkManager
	{
		
		static long GetID(string cmdText, params object[] parameters)
		{
		
			object retValue;
			using (SqlCommand cmd = DataManager.CreateCommand(cmdText, CommandType.StoredProcedure))
			{
				// Assuming correct order!
				for(int i = 0; i < cmd.Parameters.Count; i++)
				{
					cmd.Parameters[i].Value = i > parameters.Length-1 || parameters[i] == null ?
						(object)DBNull.Value  :
						parameters[i];
				}

				using (DataManager.Current.OpenConnection())
				{
					DataManager.Current.AssociateCommands(cmd);
					retValue = cmd.ExecuteScalar();
				}
			}

			if (retValue is DBNull)
				throw new ArgumentException("Gateway GK could not be retrieved because one or parameters were passed as null.");

			return (long) retValue;
		}



		public static long GetGatewayGK(int accountID, long identifier)
		{
			return GetID(
				"GkManager_GetGatewayGK(@Account_ID:Int, @Gateway_id:BigInt, @Channel_ID:Int, @Campaign_GK:BigInt, @Adgroup_GK:BigInt, @Gateway:NVarChar, @Dest_URL:NVarChar, @Reference_Type:Int, @Reference_ID:BigInt)", 
				accountID,
				identifier
			);
		}
	}

	
}
	