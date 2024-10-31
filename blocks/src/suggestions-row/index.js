import edit from './edit';
import Save from './save';

export const name = cl_blocks.i18n.block_suggestions_row_name
export const settings = {
    title: cl_blocks.i18n.block_suggestions_row_title,
    icon: 'welcome-add-page',
	category: 'conquer-local',
    parent: [ 'conquer-local/suggestions' ],
    description: cl_blocks.i18n.block_suggestions_row_description,
    support: {
        html: false
    },
    attributes: {
		url: {
			type: "string",
			default: "",
		},
        title: {
			type: "string",
			default: "",
		},
        description: {
			type: "string",
			default: "",
		},
        iconImage: {
			type: "string",
			default: "",
		},
		labelType: {
			type: "string",
			default: "iconImage",
		},
		svg_html_icon: {
			type: "string",
			default: "",
		},
	},
    edit,
 	save: Save,
}

