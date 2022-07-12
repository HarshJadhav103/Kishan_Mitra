window.onload = () => {
   /*let bannerNode = document.querySelector('[alt="www.000webhost.com"]').parentNode.parentNode;
   bannerNode.parentNode.removeChild(bannerNode);*/

   const text = document.querySelectorAll('.disclaimer')  
   for (const el of text) {  
   el.parentNode.removeChild(el);  
   }
}
