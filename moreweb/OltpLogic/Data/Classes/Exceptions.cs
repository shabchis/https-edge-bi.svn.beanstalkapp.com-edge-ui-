using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace Easynet.Edge.UI.Data
{
	[Serializable]
	public class EdgeSessionException : Exception
	{
		public EdgeSessionErrorType ErrorType { get; set; }

		public EdgeSessionException() { this.ErrorType = EdgeSessionErrorType.Unspecified; }
		public EdgeSessionException(string message, EdgeSessionErrorType errorType) : base(message) { this.ErrorType = errorType; }
		public EdgeSessionException(string message, EdgeSessionErrorType errorType, Exception inner) : base(message, inner) { this.ErrorType = errorType; }
		protected EdgeSessionException(
		  System.Runtime.Serialization.SerializationInfo info,
		  System.Runtime.Serialization.StreamingContext context)
			: base(info, context) {  }
	}

	public enum EdgeSessionErrorType
	{
		Unspecified,
		BadFormat,
		Expired,
		NotFound,
		InvalidUser
	}
}
