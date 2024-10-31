import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";

export default function Save ( { attributes } ) {
    const { eventsPageLink } = attributes
    return (
        <div { ...useBlockProps }  className="cl-block-container-fw cl-block-container-items-center">
            <div className="cl-block-container-inner-container cl-block-container-inner-center">
                <h2 className="cl-pt-color cl-block-title raleway-title">Upcoming Events</h2>
                <div className="cl-block-cl-more-event-container">
                    <InnerBlocks.Content/>
                </div>
                {eventsPageLink && <a href={eventsPageLink} style={{pointerEvents: eventsPageLink.length >=0 ? "auto" : "none"}}>
					<span className="cl-block-join-btn cl-block-cl-more-event-btn-secondary">View all events</span>
                </a>}
            </div>
        </div>
    )
}