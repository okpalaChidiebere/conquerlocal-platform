import { RangeControl, PanelBody, PanelRow, TextControl } from '@wordpress/components';
import { Fragment, useMemo } from '@wordpress/element';
import { InspectorControls, InnerBlocks } from "@wordpress/block-editor";

const MAX_CARDS = 3
const MIN_CARDS = 1
export default function edit({ attributes, setAttributes }){
	const { eventsPageLink, numOfCards } = attributes
	const TEMPLATE = useMemo(() => {
		return ([ [ 'core/columns', {},  Array(MAX_CARDS).fill().map((_, i) => (
			[ 'core/column', {},  i + 1 <= numOfCards ? [
				[ 'core/shortcode'],
			]: null ]
		))] ])
	}, [numOfCards]);

    return (
		<Fragment>
			<InspectorControls style={{ marginBottom: "40px" }}>
				<PanelBody initialOpen>
					<PanelRow>
						<RangeControl
							label="Number of Event Cards"
							value={numOfCards}
							onChange={(numOfCards) => setAttributes({numOfCards})}
							min={MIN_CARDS}
							max={MAX_CARDS}
							step={1}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
                            type="text"
                            label="Events page link URL"
                            value={eventsPageLink}
                            onChange={( eventsPageLink ) => setAttributes({ eventsPageLink })}
                        />
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<div className="cl-block-container-page-fw cl-block-container-items-center">
				<div className="cl-block-container-inner-container cl-block-container-inner-center">
					<h2 className="cl-pt-color cl-block-title raleway-title">Upcoming Events</h2>
					<div className="cl-block-cl-more-event-container">
						<InnerBlocks 
							template={TEMPLATE} 
							templateLock="all"
							allowedBlocks={["core/shortcode"]}
						/>
					</div>
					{eventsPageLink && <a href={eventsPageLink} style={{pointerEvents: eventsPageLink.length >=0 ? "auto" : "none"}}>
						<span className="cl-block-join-btn cl-block-cl-more-event-btn-secondary">View all events</span>
                    </a>}
				</div>
			</div>
		</Fragment>
    )
}