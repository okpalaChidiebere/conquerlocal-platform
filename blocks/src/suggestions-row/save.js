import parse from 'html-react-parser';

export default function Save({ attributes }) {
    return (
        <div className="cl-block-suggestions-grid-block">
            <a href={attributes.url} >
            <div className="cl-block-card cl-block-suggestions-card">
                <div className="cl-block-icon-wrapper">
                    {attributes.iconImage && attributes.labelType === "iconImage" &&
                        <img src={attributes.iconImage} alt="Icon Image" width="70%" height="70%"/>}
                    {attributes.svg_html_icon && attributes.labelType === "svgHtml" &&
                        parse(attributes.svg_html_icon)}
                </div>
                <div className="cl-block-suggestions-card-title cl-pt-color raleway-title">
                    {attributes.title}
                </div>
                <div className="cl-block-suggestions-card-description cl-st-color">
                    {attributes.description}
                </div>
            </div>
            </a>
        </div>
    )
}