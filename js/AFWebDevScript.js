//console.log("running.");


$(document).ready(function() {
  //Event Listener all get in touch & contact buttons
  let elements = document.getElementsByClassName("contact-modal");
  for (let i = 0; i < elements.length; i++) {
      elements[i].addEventListener("click", disModal);
  }
  //Event Listener For Attribution Modal
  //document.getElementById("attribution").addEventListener("click", attrModal);
   $('[data-toggle="popover"]').popover({html:true});

   //Call Meta Override
   metaOverride();

});



//Begin Function To Override Meta Title and Description
function metaOverride() {
  let servicesTitle = "AF Web Dev | Services";
  let servicesDescrip = "All plans include custom website design and development for your project or business. Including responsive website development, so every visitor to your website has a great experience.";
  let aboutTitle = "AF Web Dev | About Adrian Fregoso";
  let aboutDescrip = "Responsive Website Development, Colorado based, building custom websites to support your passion projects or small business. Adrian Fregoso | AFWebDev - Plans starting at $25/month.";

  //possibly use switch for logic?
  let cur_url = window.location.href;
  console.log(cur_url);
  switch (cur_url) {
    case 'https://php.afwebdev.com/services.php':
      console.log("services called.")
      //Change Title
      document.title = servicesTitle;
      //Change Description
      document.querySelector('meta[name="description"]').content = servicesDescrip;
      break;
    case 'https://php.afwebdev.com/about.php':
      //Change Title
      document.title = aboutTitle;
      //Change Description
      document.querySelector('meta[name="description"]').content = aboutDescrip;
      break;
    default:
  }
}
//End of metaOverride function
