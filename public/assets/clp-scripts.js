/**
 * JQuery is Forbidden!!!!
 */

 document.addEventListener('DOMContentLoaded', function(){

    var CLPlatformTools = {};

    CLPlatformTools.init = function() {
        CLPlatformTools.handle_cl_block_communitity_discussions_display();
        CLPlatformTools.initialize_banners();
        CLPlatformTools.handle_log_help_center_search();
        CLPlatformTools.handle_post_hog_init();
        CLPlatformTools.handle_start_learnDash_course();
    };

    CLPlatformTools.handle_start_learnDash_course = function() {
      const isLoggedIn = document.body.classList.contains('logged-in');
      const button = document.getElementsByClassName("AnC-Link")

      if(!isLoggedIn && button.length){
         const url = `${frontend_clp_object.login_url}?redirect_to=${window.location.href}/&conversion_point=Conquer Local Academy Signup&visitor_id=b181d014-b039-4fee-adce-9c486cfbce51.1615927885.1.1617821567.1615927885.441f6f41-b428-4e97-b9ce-cbf896e406dbcccccclurhcvfvevbjdhtcgcndghbttltftelhvdjdec`

         button[0].href = `https://signup.vendasta.com/?marketingContentId=academy&nextUrl=${url}`
         button[0].target = "_self"
      }
    }

    CLPlatformTools.handle_post_hog_init = function() {
      const getPostHogIdentifyDetails = async () => {
         const data = {action: 'posthog_capture_user_info'}

         return fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(data)
          }).then(response => response.json())
      }

      posthog.init('oet8qnSAuaVxnNAB4uOIFnxOFnkOy8qOXZTDwsafErE', {
         api_host: 'https://pa.apigateway.co',
         loaded: async function(posthog) { 
            if(window.location.href.indexOf("imp=") == -1){
               const posthog_response = await getPostHogIdentifyDetails();
               if(posthog_response.success){
                  posthog.identify(posthog_response.data.userID,
                     {isVendastian : posthog_response.data.has_vendasta_email}
                  );
               }
            }	
         }
      });
    }

    CLPlatformTools.handle_log_help_center_search = async function() {

      const saveInput = async (keyword, has_results = 0, source_of_search) => {
         let data = {
				keyword,
				source_of_search,
				action: 'bb_search_logging',
				has_results
			}
         return fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams(data)
          }).then(response => response.json())
      }

      const  updateInput = (post_id, user_clicked = 0,clicked_url = "") => {
         const data = {
            post_id,
            user_clicked,
            clicked_url,
            action: 'bb_search_update'
         }
         if(post_id && user_clicked){
            fetch('/wp-admin/admin-ajax.php', {
               method: 'POST',
               headers: {
                 'Content-Type': 'application/x-www-form-urlencoded'
               },
               body: new URLSearchParams(data)
             }).then(response => response.json())
         }
      }
    
		if( window.location.href.indexOf("clps=") > -1 ){
			const url_string = window.location.href
			const url = new URL(url_string)
			const keyword = url.searchParams.get("clps")
			const search_content = document.getElementsByClassName("clps-item")

			if(search_content.length){
            const {data: {id: post_id}}  = await saveInput(keyword, 1,"help_center")
					Array.from(search_content).forEach((search) => {
						//set event listeners foreach result
						search.addEventListener('click', (event) =>{
                     event.preventDefault()
                     let clicked_url = search.href
                     console.log(clicked_url)
                     updateInput(post_id, 1,clicked_url)
                     window.open(clicked_url, clicked_url.includes("support.vendasta.com") ? '_blank' : '_self', 'noopener')
						})
					})
			}
			else{
				saveInput(keyword, 0,"help_center")
			}
		}
   }

    CLPlatformTools.initialize_banners = function() {
      let timer = 0
      let slideIndex = 1
      let bannerIndicators =  document.getElementsByClassName("custom-banner-dot")
      const showSlides = (n) => {
         let i;
         let slides = document.getElementsByClassName("custom-slides-wrapper");
         if(slides.length > 0){
            for (i = 0; i < slides.length; i++) {
               slides[i].style.display = "none";  
            }
      
            if (n > slides.length) {slideIndex = 1}    
            if (n < 1) {slideIndex = slides.length}
      
            for (i = 0; i < bannerIndicators.length; i++) {
               bannerIndicators[i].className = bannerIndicators[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            bannerIndicators[slideIndex-1].className += " active";
            timer = setTimeout(() => currentSlide(slideIndex + 1), 15000); // Change image every 15 seconds
         }
      }
      const currentSlide = (n) => {
         clearTimeout(timer)
         showSlides(slideIndex = n);
      }

      Array.from(bannerIndicators).forEach((button, index) => {
         button.addEventListener('click', (evt) => {
            currentSlide(index + 1)
         });
      }); 

      if(bannerIndicators.length){
         showSlides(slideIndex);
      }
    }

    CLPlatformTools.handle_cl_block_communitity_discussions_display = function() {
        const trendingPosts = document.getElementsByClassName('cl-block-trending-posts')
        const latestPosts = document.getElementsByClassName('cl-block-latest-posts')
        const trendingRadio = document.getElementById('cl-block-trending-radio')
        const latestRadio = document.getElementById('cl-block-latest-radio')
        const activeRadioClass = "cl-block-community-discussions-switch-active-item"
   
       //initially hide the latest posts
        Array.from(latestPosts).forEach(post => post.style.display = 'none' );
        trendingRadio?.classList.add(activeRadioClass);
   
        trendingRadio?.addEventListener("click", () => {
           trendingRadio.classList.add(activeRadioClass);
           latestRadio.classList.remove(activeRadioClass);
   
           Array.from(latestPosts).forEach(post => post.style.display = 'none' );
           Array.from(trendingPosts).forEach(post => post.style.display = 'flex' );
   
        })
        latestRadio?.addEventListener("click", () => {
           trendingRadio.classList.remove(activeRadioClass);
           latestRadio.classList.add(activeRadioClass);
   
           Array.from(trendingPosts).forEach(post => post.style.display = 'none' );
           Array.from(latestPosts).forEach(post => post.style.display = 'flex' );
       })
    };
    
    CLPlatformTools.init();
 })
