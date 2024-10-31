import { Fragment, useCallback, createRef } from '@wordpress/element';
import { Disabled } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';

export default function edit({ attributes, setAttributes }){
    const mediaUploadRef = createRef()
	const handleSetImage = useCallback((background_image) => {
        setAttributes({ background_image })
    }, [])
    return (
		<Fragment>
			{/** whatever the InspectorControls wraps will appear on 
			 * the block sideBar as the user edit our custom block */}
            <InspectorControls>
				<PanelBody title="Block Background Image Settings" initialOpen>
                    <p><strong>Select a Background Image:</strong></p>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={(newImage) => {
                                 //ideally, you want to render different images sizes based on the screeonsize but this will do :)
                                handleSetImage(newImage.sizes.full.url)
                            }}
                            allowedTypes={["image"]}
                            value={ attributes.background_image }
                            render={ ( { open } ) => (
                                attributes.background_image ? 
                                <img ref={mediaUploadRef} src={`${attributes.background_image}`} 
                                    width="500" height="600" 
                                    onClick={open} 
                                    style={{ cursor: 'pointer'}}
                                ></img>
                                : <Button
                                    icon="upload"
                                    onClick={open}>
                                    Background Image
                                </Button>
                            )}
                        />
                    </MediaUploadCheck>
                    {attributes.background_image && (
                        <div style={{ display: "flex", flexDirection: "column"}}>
                            <span style={{ marginBottom: "10px"}}>
                                <Button variant="secondary" onClick={() => mediaUploadRef.current.click()}>
                                    Replace image
                                </Button>
                            </span>
                            <span>
                                <Button isDestructive variant="link" onClick={() => handleSetImage("")}>
                                    Remove Cover Photo
                                </Button>     
                            </span>
                        </div>            
                    )}
				</PanelBody>
			</InspectorControls>
			<Disabled>
				<ServerSideRender
					block="conquer-local/search"
					attributes={ attributes } //the attributes MUST be defined in php as well. See https://github.com/WordPress/gutenberg/tree/trunk/packages/server-side-render
				/>
			</Disabled>
		</Fragment>
    )
}