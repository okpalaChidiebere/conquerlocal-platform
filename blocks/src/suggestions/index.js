
import { InnerBlocks, useBlockProps } from "@wordpress/block-editor";
import edit from './edit';

export const name = cl_blocks.i18n.block_suggestions_name;

export const settings = {
    title: cl_blocks.i18n.block_suggestions_title,
	description: cl_blocks.i18n.block_suggestions_description,
	icon: 'category',
	category: 'conquer-local', 
	supports: {
		customClassName: false,
	},
	edit,
	save: function( props ) {
		return (
			<div { ...useBlockProps } className="cl-block-container-fw cl-block-container-fw-mobile">
                <div className={props.attributes.classNames} >
                    <div className="cl-block-suggestions-grid">
						<InnerBlocks.Content/>
                    </div>
                </div>
            </div>
		)
	},
	attributes: {
		classNames: {
			default: "neg-margin",
			type: "string",
		},
	},
}