import { Fragment } from '@wordpress/element';
import {
	InspectorControls,
    MediaUpload, 
    MediaUploadCheck,
    RichText, 
    PlainText,
} from "@wordpress/block-editor";
import {
    Button,
	PanelBody,
	PanelRow,
    TextControl,
	Dashicon,
    RadioControl,
} from "@wordpress/components";
export default function edit({ attributes, setAttributes }){

    return (
        <Fragment>
            <InspectorControls style={{ marginBottom: "40px" }}>
				<PanelBody initialOpen>
					<PanelRow>
                        <RadioControl
						 label="Learner Path Label"
						 help="The type of label you want for this learner path. Could be an image or svg path"
						 selected={ attributes.labelType }
						 options={[
							{ label: "Upload An Icon image", value: "iconImage" },
							{ label: "Enter an SVG path", value: "svgPath" },
						 ]}
						 onChange={(labelType) => setAttributes({ labelType })}
						/>
                    </PanelRow>
                    <PanelRow>
                        {attributes.labelType === "svgPath"
                        ? (<PlainText
                            type="text"
                            placeholder='Enter a your SVG path'
                            value={attributes.svgPath}
                            onChange={ svgPath =>  setAttributes({ svgPath })}
                            style={{ maxHeight: 100, minHeight: 100 }}
                            />)
                        : (<MediaUploadCheck>
                            <MediaUpload
                                onSelect={(newImage) => setAttributes({ iconImage: newImage.sizes.full.url  })}
                                allowedTypes={["image"]}
                                value={ attributes.iconImage }
                                render={ ( { open } ) => (
                                    attributes.iconImage ? 
                                    <img src={`${attributes.iconImage}`} 
                                        width="500" height="600" 
                                        onClick={open} 
                                        style={{ cursor: 'pointer'}}
                                    ></img>
                                    : <div>
                                        <p><strong>Select a Learner Path Icon Image:</strong></p>
                                        <Button
                                            icon="upload"
                                            onClick={open}>
                                            Icon Image
                                        </Button>
                                    </div>
                                )}
                            />
                        </MediaUploadCheck>)}
					</PanelRow>
				</PanelBody>
                <PanelBody title='URL' initialOpen>
                    <PanelRow>
                        <TextControl
                            type="text"
                            placeholder='Enter Learner path reference link'
                            value={attributes.url}
                            onChange={ ( url ) => setAttributes({ url }) }
                            style={{ width: "100%" }}
                        />
                    </PanelRow>
                </PanelBody>
			</InspectorControls>
            <div className="cl-block-gwv-course">
                <div className="cl-block-gwv-course-left-wrapper">
                    <div className="cl-block-icon-wrapper cl-block-gwv-course-icon">
                        {attributes.iconImage && attributes.labelType === "iconImage" &&
                        <img src={attributes.iconImage} alt="Icon Image" width="70%" height="70%"/>}
                        {attributes.svgPath && attributes.labelType === "svgPath" &&
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d={attributes.svgPath} fill="white"/>
                        </svg>}
                    </div>
                    <div className="cl-block-gwv-course-title-duration-wrapper">
                        <RichText 
                            tagName="span"
                            placeholder="Your Learner Path Title"
                            value={attributes.primaryText}
                            onChange={(primaryText) => setAttributes({ primaryText })}
                            className="cl-block-gwv-course-title cl-pt-color raleway-title"
                            />
                        <RichText 
                            tagName="span"
                            placeholder="Secondary text"
                            value={attributes.secondaryText}
                            onChange={(secondaryText) => setAttributes({ secondaryText })}
                            className="cl-block-gwv-course-duration cl-st-color"
                        />
                    </div>
                </div>
                <div className="cl-block-gwv-course-right-wrapper">
                    <Dashicon icon="arrow-right-alt2" style={{fontSize: '21px'}} />
                </div>
            </div>
        </Fragment>
    )
}