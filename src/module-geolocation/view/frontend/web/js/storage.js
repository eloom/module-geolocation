define(["jquery","mage/storage","jquery/jquery-storageapi"],function(f){var a=f.initNamespaceStorage("eloom-storage").localStorage,c=function(){a.get("geoLocAddress")||e();return a.get("geoLocAddress")},e=function(){a.set("geoLocAddress",{hasData:!1,address:null})};return{reset:function(){e()},hasData:function(){return c().hasData},setHasData:function(d){var b=c();b.hasData=d;a.set("geoLocAddress",b)},getAddressData:function(){return c().address},setAddressData:function(d){this.setHasData(!0);var b=
c();b.address=d;a.set("geoLocAddress",b)}}});
