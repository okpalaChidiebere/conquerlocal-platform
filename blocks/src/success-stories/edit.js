import { Fragment } from '@wordpress/element';
import {
	RichText, 
	InspectorControls,
	MediaUpload, 
    MediaUploadCheck,} 
from "@wordpress/block-editor";
import {
    Button,
	PanelBody,
	PanelRow,
    TextControl,
} from "@wordpress/components";

export default function edit({ attributes, setAttributes }){

    return (
       <Fragment>
		<InspectorControls>
			<PanelBody initialOpen>
					<PanelRow>
                        <MediaUploadCheck>
                            <MediaUpload
                                onSelect={(newImage) => setAttributes({ imageUrl: newImage.sizes.full.url  })}
                                allowedTypes={["image"]}
                                value={ attributes.imageUrl }
                                render={ ( { open } ) => (
                                    attributes.imageUrl ? 
                                    <img src={`${attributes.imageUrl}`} 
                                        width="500" height="600" 
                                        onClick={open} 
                                        style={{ cursor: 'pointer'}}
                                    ></img>
                                    : <div>
                                        <p><strong>Select a Success stories Image:</strong></p>
                                        <Button
                                            icon="upload"
                                            onClick={open}>
                                            Success Stories image
                                        </Button>
                                    </div>
                                )}
                            />
                        </MediaUploadCheck>
					</PanelRow>
                    <PanelRow>
                        <TextControl
                            type="text"
                            label="read more Link URL"
                            value={attributes.linkUrl}
                            onChange={ ( linkUrl ) => setAttributes({ linkUrl }) }
                        />
                    </PanelRow>
				</PanelBody>
		</InspectorControls>
			<div className="cl-block-container-page-fw cl-block-container-items-center" style={{background: "#072337"}}>
					<div className="cl-block-container-inner-container cl-block-container-inner-center">
						<h2 className="cl-block-title raleway-title" style={{color: "#FFFFFF"}}>Partner Success Stories</h2>
						<div className="cl-block-join-cl-card-container cl-block-sucess-stories-mobile cl-block-sucess-stories-desk" style={{flexDirection : "row" ,width: "87%"}}>
							<div style={{display: "flex", flexDirection: "column", flex: 1, paddingBottom: 30}}>
							<span className="cl-block-ps-story-quote"><img className="cl-quote-image" src="https://conquer-local-academy.websitepro-staging.com/wp-content/uploads/2022/08/green-quotation-1.png"></img></span>
								<RichText 
									tagName="span"
									placeholder="Your Quote here"
									value={attributes.quote}
									onChange={(quote) => setAttributes({ quote})}
									className="cl-block-ps-story"
								/>
								<div className="cl-block-ps-story-partner">
									<RichText 
										tagName="span"
										placeholder="Your name here"
										value={attributes.name}
										onChange={(name) => setAttributes({ name})}
										className="cl-block-ps-story-partner-name"
									/>
									<RichText 
										tagName="span"
										placeholder="Your title and company here"
										value={attributes.personTitle}
										onChange={(personTitle) => setAttributes({ personTitle})}
										className="cl-block-ps-story-partner-role"
									/>
								</div>
								<div>
									<a href={attributes.linkUrl} style={{pointerEvents: attributes.linkUrl.length >=0 ? "auto" : "none"}}>
									<span className="cl-block-join-btn cl-block-cl-more-podcasts-btn">Read Story →</span>
									</a>
								</div>
							</div>
							<div style={{display: "flex", flexDirection: "column", flex:1}}>
								<div className="cl-block-ps-banner" style={{backgroundImage: `url(${attributes.imageUrl})`,backgroundSize: 'cover',backgroundPosition: 'center',backgroundRepeat: 'no-repeat'}}>
								</div>
								<div className="cl-block-ps-result">
									<span>Results</span>
									<RichText 
										tagName="span"
										placeholder="Your revenue/impact go here"
										value={attributes.impactBlob}
										onChange={(impactBlob) => setAttributes({ impactBlob})}
										style={{fontSize: 30, fontWeight: "700", padding: "5px 20px"}}
									/>
									<span style={{fontSize: 12}}>Revenue Growth</span>
								</div>
							</div>
						</div>
					</div>
			</div>
	   </Fragment>
    )
}