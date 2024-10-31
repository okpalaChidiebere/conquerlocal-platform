import edit from './edit';
import Save from './save';

export const name = cl_blocks.i18n.block_learner_path_row_name
export const settings = {
    title: cl_blocks.i18n.block_learner_path_row_title,
    icon: 'welcome-add-page',
	category: 'conquer-local',
    parent: [ 'conquer-local/learner-path' ],
    description: cl_blocks.i18n.block_learner_path_row_description,
    support: {
        html: false
    },
    attributes: {
		url: {
			type: "string",
			default: "",
		},
        primaryText: {
			type: "string",
			default: "",
		},
        secondaryText: {
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
		svgPath: {
			type: "string",
			default: "",
		},
	},
    edit,
 	save: Save,
}

