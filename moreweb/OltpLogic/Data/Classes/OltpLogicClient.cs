using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Easynet.Edge.Core.Services;
using Easynet.Edge.UI.Data;
using Easynet.Edge.UI.Server;
using System.Configuration;

namespace Easynet.Edge.UI.Client
{
	public class OltpLogicClient: IDisposable
	{
		#region Public
		//=========================

		public OltpLogicClient(string sessionID)
		{
			// Automatically restart session
			SessionStart(CurrentSessionID);
		}

		public string CurrentSessionID
		{
			get { return _currentSessionID; }
		}

		public Oltp.UserRow CurrentUser
		{
			get { return _currentUser; }
		}

		public IOltpLogic Service
		{
			get { return _internalProxy.Service; }
		}

		void IDisposable.Dispose()
		{
			SessionEnd();
		}

		//=========================
		#endregion

		#region Private
		//=========================

		string _currentSessionID;
		Oltp.UserRow _currentUser = null;
		ServiceClient<IOltpLogic> _internalProxy = null;

		void InitProxy()
		{
			if (_internalProxy != null &&
				_internalProxy.State != System.ServiceModel.CommunicationState.Closed &&
				_internalProxy.State != System.ServiceModel.CommunicationState.Faulted)
			{
				throw new InvalidOperationException("A session is already open.");
			}

			_internalProxy = new ServiceClient<IOltpLogic>("IOltpLogic_Endpoint");
		}

		void SessionStart(string sessionID)
		{
			InitProxy();
			_currentUser = (Oltp.UserRow)_internalProxy.Service.User_LoginBySessionID(sessionID).Rows[0];
			_currentSessionID = sessionID;
		}


		void SessionEnd()
		{
			if (_internalProxy != null && _internalProxy.State == System.ServiceModel.CommunicationState.Opened)
			{
				using (_internalProxy)
					_internalProxy.Close();
			}
		}
		

		//=========================
		#endregion
	}
}
