/**
 * JQuery is Forbidden here!!!!
 */
 document.addEventListener('DOMContentLoaded', function(){
    let CLPlatformAdminTools = {}

    CLPlatformAdminTools.init = function() {
        CLPlatformAdminTools.handle_upload_banner_image()
    };

    CLPlatformAdminTools.handle_upload_banner_image = function() {
        document.querySelectorAll('.clp-upload-media').forEach((button) => {
            button.addEventListener('click', (evt) => {
                evt.preventDefault()
                const elementInput = evt.currentTarget.closest(".clp-media-uploader").querySelector('input[type=text]')
                clp_media_uploader().then((response) => {
                    elementInput.value = response.url // Set the data
                }); 
              });
         }); 
    };
    
    CLPlatformAdminTools.init()
 })


/**
 * Display the media uploader.
 *
 * @since 1.1.0
 */
function clp_media_uploader() { 
    return new Promise((resolve, reject) => {
        let file_frame, attachment
        // If an instance of file_frame already exists, then we can open it rather than creating a new instance
       if ( file_frame ) {
           file_frame.open()
           return;
       }; 
        /**
         * Use the wp.media library to define the settings of the media uploader
         * for more wp.media
         * @see https://codex.wordpress.org/Javascript_Reference/wp.media
         */
       file_frame = wp.media.frames.file_frame = wp.media({
           frame: 'post',
           state: 'insert',
           multiple: false
       })
       // Setup an event handler for what to do when a media has been selected
       file_frame.on( 'insert', () => { 
           // Read the JSON data returned from the media uploader
           attachment = file_frame.state().get( 'selection' ).first().toJSON()
    
           // First, make sure that we have the URL of the media to display
           if ( 0 > $.trim( attachment.url.length ) ) {
               reject();
           };
           resolve(attachment)
       })
       // Now display the actual file_frame
    	file_frame.open();
    })
    // file_frame.on( 'close', () => { 
    // })
  }
