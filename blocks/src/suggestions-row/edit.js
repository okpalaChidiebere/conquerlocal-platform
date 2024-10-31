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
    RadioControl,
} from "@wordpress/components";
import { Fragment } from '@wordpress/element'
import parse from 'html-react-parser';


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
							{ label: "Enter an SVG path", value: "svgHtml" },
						 ]}
						 onChange={(labelType) => setAttributes({ labelType })}
						/>
                    </PanelRow>
                    <PanelRow>
                        {attributes.labelType === "svgHtml"
                        ? (<PlainText
                            type="text"
                            placeholder='Enter a your SVG html string'
                            value={attributes.svg_html_icon}
                            onChange={ svg_html_icon =>  setAttributes({ svg_html_icon })}
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
                                        <p><strong>Select the card action icon Image:</strong></p>
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
                    <PanelRow>
                        <TextControl
                            type="text"
                            placeholder='Enter card link'
                            value={attributes.url}
                            onChange={ ( url ) => setAttributes({ url }) }
                            style={{ width: "100%" }}
                        />
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <div className="cl-block-suggestions-grid-block">
                <a href={attributes.url} style={{pointerEvents: 'none'}}>
                <div className="cl-block-card cl-block-suggestions-card">
                    <div className="cl-block-icon-wrapper" >
                        {attributes.iconImage && attributes.labelType === "iconImage" &&
                            <img src={attributes.iconImage} alt="Icon Image" width="70%" height="70%"/>}
                        {attributes.svg_html_icon && attributes.labelType === "svgHtml" &&
                            parse(attributes.svg_html_icon)}
                    </div>
                    <RichText 
                        tagName="span"
                        placeholder="Your Learner Path Title"
                        value={attributes.title}
                        onChange={(title) => setAttributes({ title })}
                        className="cl-block-suggestions-card-title cl-pt-color raleway-title"
                        />
                    <RichText 
                        tagName="span"
                        placeholder="Secondary text"
                        value={attributes.description}
                        onChange={(description) => setAttributes({ description })}
                        className="cl-block-suggestions-card-description cl-st-color"
                    />    
                </div>
                </a>
            </div>
        </Fragment>
    )
}