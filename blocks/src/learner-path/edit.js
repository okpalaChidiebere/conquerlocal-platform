import { InnerBlocks, useBlockProps  } from '@wordpress/block-editor';
import { name as learnerPathRowBlockName } from "../learner-path-row";

const MY_TEMPLATE = [
	[ learnerPathRowBlockName ],
]

export default function edit(props){
    return (
		<div { ...useBlockProps } className="cl-block-container-fw">
			<div className="cl-block-container-inner-container" style={{ padding: '50px 0px'}}>
				<h2 class="cl-pt-color cl-block-title" style={{alignSelf: "center"}}>Grow your business with Vendasta</h2>
				<InnerBlocks
					template={MY_TEMPLATE} 
					allowedBlocks={[learnerPathRowBlockName]} //specify the child blocks the user is only allowed to insert
				/>
			</div>
		</div>
    )
}