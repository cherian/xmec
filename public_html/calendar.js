
		var isIE;
		isIE = (document.all) ? true : false;

		function tdmouseover(itemID)
		{
		   if(isIE)
		   {
		      var theObj = eval("document.all." + itemID);
          theObj.style.backgroundColor = '#ECECEC'; /* '#'.$mouse_over_color.'\'; */
		   }
		}

		function tdmouseout(itemID)
		{
		   if(isIE)
		   {
		      var theObj = eval("document.all." + itemID);

		      theObj.style.backgroundColor = '#FFFFFF'; /* '#'.$calendar_bg_color.'\'; */
		   }
		}

		function tdcurmouseout(itemID)
		{
		   if(isIE)
		   {
		      var theObj = eval("document.all." + itemID);

		      theObj.style.backgroundColor = '#E7F3FB'; /*'#'.$current_day_color.'\';*/
		   }
		}
