export default function Save({ attributes }) {
    const { primaryText, iconImage, secondaryText, url } = attributes
    return (
        <div className="cl-block-container-page-fw cl-block-container-items-center" style={{background: "#072337"}}>
         <div className="entry-content" style={{display: "flex", justifyContent: "center"}}>
            <div className="cl-block-container-inner-container cl-block-container-inner-center cl_ss_container">
                <h2 className="cl-block-title raleway-title" style={{color: "#FFFFFF"}}>Partner Success Stories</h2>
                <div className="cl-block-join-cl-card-container cl-block-sucess-stories-mobile cl-block-sucess-stories-desk">
                    <div className = "cl-block-ps-story-quote-container ">
                        <span className="cl-block-ps-story-quote"><img className="cl-quote-image" src="https://conquer-local-academy.websitepro-staging.com/wp-content/uploads/2022/08/green-quotation-1.png"></img></span>
                        <span className="cl-block-ps-story">{attributes.quote}</span> 
                        <div className="cl-block-ps-story-partner">
                            <span className="cl-block-ps-story-partner-name">{attributes.name}</span>
                            <span className="cl-block-ps-story-partner-role">{attributes.personTitle}</span>
                        </div>
                        <div>
                            <a href={attributes.linkUrl} style={{pointerEvents: attributes.linkUrl.length >=0 ? "auto" : "none"}}>
                                <span className="cl-block-join-btn cl-block-cl-more-success-btn">Read Story →</span>
                            </a>
                        </div>
                    </div>
                    <div className="cl-block-ps-banner-container" >
                        <div className="cl-block-ps-banner" style={{backgroundImage: `url(${attributes.imageUrl})`,backgroundSize: 'cover',backgroundPosition: 'center',backgroundRepeat: 'no-repeat'}}>
                        </div>
                        <div className="cl-block-ps-result">
                            <span>Results</span>
                            <span style={{fontSize: 30, fontWeight: "700", padding: "5px 20px"}}>{attributes.impactBlob}</span>
                            <span style={{fontSize: 12}}>Revenue Growth</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    );
}