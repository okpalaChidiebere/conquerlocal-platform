import { Dashicon } from "@wordpress/components";

export default function Save({ attributes }) {
    const { primaryText, iconImage, secondaryText, url, labelType, svgPath } = attributes
    return (
        <a className ="cl-block-lp-grid-row-a" href={url.length ? url : "#"}>
            <div className="cl-block-gwv-course">
                <div className="cl-block-gwv-course-left-wrapper">
                    <div className="cl-block-icon-wrapper cl-block-gwv-course-icon">
                        {iconImage && labelType === "iconImage" &&
                        <img src={iconImage} alt="Icon Image" width="70%" height="70%"/>}
                        {svgPath && labelType === "svgPath" &&
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d={svgPath} fill="white"/>
                        </svg>}
                    </div>
                    <div className="cl-block-gwv-course-title-duration-wrapper">
                        <span className="cl-block-gwv-course-title cl-pt-color raleway-title">{primaryText}</span>
                        <span className="cl-block-gwv-course-duration cl-st-color">{secondaryText}</span>
                    </div>
                </div>
                <div className="cl-block-gwv-course-right-wrapper">
                    <Dashicon icon="arrow-right-alt2" style={{fontSize: '21px'}} />
                </div>
            </div>
        </a>
    );
}