/*
This script will detect country location of the visitor by calling to ipinfo.io API.

In this use case, I have three server for my website, default is located in Singapore, one located in New Jersey, and the other located in Hong Kong. 
All three server has been configured with this javascript in the footer part.

I have two arrays of country codes, each located near to my server.
Find your contry code here: https://en.wikipedia.org/wiki/List_of_ISO_3166_country_codes

This script requires jQuery to work ($.get), you can convert it to Vanilla Javascript if you have the time.

*/

// redirecting user to nearby server
$(function(){
      var nearUS = ["US" , "CA", "BR", "MX", "BS", "AW", "CU", "DE", "UK", "GL", "IE", "IS" ]; // For New york server
      var nearHK = ["CN" , "HK", "BR", "MN", "TW", "RU", "JP", "KR", "KP", "VN", "LA", "KH" ]; // For hongkong server
      var thisserver = "www"; //change based on server where this javascript is hosted, change to "www" / "us" / "hk"
      var toserver = "www"; // dont change, use this for default server 
      $.get("https://ipinfo.io/json", function (response) {
          console.log("Your are in "+response.city+" "+response.region+", "+response.country);
          if(nearUS.includes(response.country)) {
            console.log("We will redirect you to our US server");                
            toserver = "us";
          }
          if(nearHK.includes(response.country)) {
            console.log("We will redirect you to our HK server");                
            toserver = "hk";
          }
        if(toserver != thisserver) {
            console.log("Redirecting to "+ toserver +" server");
            window.location = "https://"+toserver+".andiim3.com" + window.location.pathname;                
          }else{
                console.log("You will stay in "+thisserver+" server.");
          }
      }, "jsonp");  
});
