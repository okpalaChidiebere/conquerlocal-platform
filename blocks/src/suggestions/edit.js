import { PanelBody, TextControl } from '@wordpress/components';
import { InnerBlocks, InspectorControls } from '@wordpress/block-editor'
import { Fragment, useMemo } from '@wordpress/element'

import { name as suggestionsRowBlockName } from '../suggestions-row';

const base_url = ''
let suggestions = [
	{
		'svg_html_icon' : `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M6.66634 17.5733V22.9067L15.9997 28L25.333 22.9067V17.5733L15.9997 22.6667L6.66634 17.5733ZM15.9997 4L1.33301 12L15.9997 20L27.9997 13.4533V22.6667H30.6663V12L15.9997 4Z" fill="white"/>
		</svg>`,
		'title' : 'Academy',
		'description' : 'Learn to grow your business through our online courses',
		'url' : `${base_url}/academy`,
		labelType: "svgHtml",
		// iconImage: '',
	},
	{
		'svg_html_icon' : `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M16 17C18.1733 17 20.0933 17.52 21.6533 18.2C23.0933 18.84 24 20.28 24 21.84V24H8V21.8533C8 20.28 8.90667 18.84 10.3467 18.2133C11.9067 17.52 13.8267 17 16 17ZM5.33333 17.3333C6.8 17.3333 8 16.1333 8 14.6667C8 13.2 6.8 12 5.33333 12C3.86667 12 2.66667 13.2 2.66667 14.6667C2.66667 16.1333 3.86667 17.3333 5.33333 17.3333ZM6.84 18.8C6.34667 18.72 5.85333 18.6667 5.33333 18.6667C4.01333 18.6667 2.76 18.9467 1.62667 19.44C0.64 19.8667 0 20.8267 0 21.9067V24H6V21.8533C6 20.7467 6.30667 19.7067 6.84 18.8ZM26.6667 17.3333C28.1333 17.3333 29.3333 16.1333 29.3333 14.6667C29.3333 13.2 28.1333 12 26.6667 12C25.2 12 24 13.2 24 14.6667C24 16.1333 25.2 17.3333 26.6667 17.3333ZM32 21.9067C32 20.8267 31.36 19.8667 30.3733 19.44C29.24 18.9467 27.9867 18.6667 26.6667 18.6667C26.1467 18.6667 25.6533 18.72 25.16 18.8C25.6933 19.7067 26 20.7467 26 21.8533V24H32V21.9067ZM16 8C18.2133 8 20 9.78667 20 12C20 14.2133 18.2133 16 16 16C13.7867 16 12 14.2133 12 12C12 9.78667 13.7867 8 16 8Z" fill="white"/>
		</svg>`,
		'title' : 'Community',
		'description' : 'Connect with like-minded people, find answers and ask questions',
		'url' : base_url + "/community",
		labelType: "svgHtml",
		// iconImage: '',
	},
	{
		'svg_html_icon' : `<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M16.0003 18.6666C18.2137 18.6666 19.987 16.88 19.987 14.6666L20.0003 6.66663C20.0003 4.45329 18.2137 2.66663 16.0003 2.66663C13.787 2.66663 12.0003 4.45329 12.0003 6.66663V14.6666C12.0003 16.88 13.787 18.6666 16.0003 18.6666ZM23.067 14.6666C23.067 18.6666 19.6803 21.4666 16.0003 21.4666C12.3203 21.4666 8.93366 18.6666 8.93366 14.6666H6.66699C6.66699 19.2133 10.2937 22.9733 14.667 23.6266V28H17.3337V23.6266C21.707 22.9866 25.3337 19.2266 25.3337 14.6666H23.067Z" fill="white"/>
		</svg>`,
		'title' : 'Learn On the Go',
		'description' : 'Listen to top marketers, sales and business leaders for tactical advice',
		'url' : base_url + "/podcasts",
		labelType: "svgHtml",
		// iconImage: '',
	},
	{
		'svg_html_icon' : `<svg width="24" height="27" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M18.6667 15H12V21.6667H18.6667V15ZM17.3333 0.333374V3.00004H6.66667V0.333374H4V3.00004H2.66667C1.18667 3.00004 0.0133333 4.20004 0.0133333 5.66671L0 24.3334C0 25.8 1.18667 27 2.66667 27H21.3333C22.8 27 24 25.8 24 24.3334V5.66671C24 4.20004 22.8 3.00004 21.3333 3.00004H20V0.333374H17.3333ZM21.3333 24.3334H2.66667V9.66671H21.3333V24.3334Z" fill="white"/>
		</svg>`,
		'title' : 'Community Sessions',
		'description' : 'Discover the latest events, connect with experts, and get motivation',
		'url' : base_url + "/videos",
		labelType: "svgHtml",
		// iconImage: '',
	},
	{
		'svg_html_icon' : `<svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M19.3337 0L22.387 3.05333L15.8803 9.56L10.547 4.22667L0.666992 14.12L2.54699 16L10.547 8L15.8803 13.3333L24.2803 4.94667L27.3337 8V0H19.3337Z" fill="white"/>
		</svg>`,
		'title' :  'Vendasta Workshop Program',
		'description' :  'Join the discussion on Vendasta fundamentals',
		'url' :  base_url + "/groups/workshops/",
		labelType: "svgHtml",
		// iconImage: '',
	},
	{
		'svg_html_icon' : `<svg width="28" height="24" viewBox="0 0 28 24" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M26.0003 12.2933C26.0003 4.97333 20.3203 0 14.0003 0C7.74699 0 2.00033 4.86667 2.00033 12.3733C1.20033 12.8267 0.666992 13.68 0.666992 14.6667V17.3333C0.666992 18.8 1.86699 20 3.33366 20H4.66699V11.8667C4.66699 6.70667 8.84033 2.53333 14.0003 2.53333C19.1603 2.53333 23.3337 6.70667 23.3337 11.8667V21.3333H12.667V24H23.3337C24.8003 24 26.0003 22.8 26.0003 21.3333V19.7067C26.787 19.2933 27.3337 18.48 27.3337 17.52V14.4533C27.3337 13.52 26.787 12.7067 26.0003 12.2933Z" fill="white"/>
		<path d="M10.0003 14.6667C10.7367 14.6667 11.3337 14.0697 11.3337 13.3333C11.3337 12.597 10.7367 12 10.0003 12C9.26395 12 8.66699 12.597 8.66699 13.3333C8.66699 14.0697 9.26395 14.6667 10.0003 14.6667Z" fill="white"/>
		<path d="M18.0003 14.6667C18.7367 14.6667 19.3337 14.0697 19.3337 13.3333C19.3337 12.597 18.7367 12 18.0003 12C17.2639 12 16.667 12.597 16.667 13.3333C16.667 14.0697 17.2639 14.6667 18.0003 14.6667Z" fill="white"/>
		<path d="M22.0006 10.7067C21.3606 6.90667 18.0539 4 14.0673 4C10.0273 4 5.68061 7.34667 6.02728 12.6C9.32061 11.2533 11.8006 8.32 12.5073 4.74667C14.2539 8.25333 17.8406 10.6667 22.0006 10.7067Z" fill="white"/>
		</svg>`,
		'title': 'Need Help?',
		'description' : 'Stuck somewhere? Connect with Vendasta experts',
		'url' : "https://support.vendasta.com/hc/en-us",
		labelType: "svgHtml",
		// iconImage: '',
	}
];

// const TEMPLATE = Array(2).fill().map((_, i) => {
// 	return ([ [ 'core/columns', {},  Array(3).fill().map((_, i) => (
// 		[ 'core/column', {},  suggestions.splice(0,3).map(attributes => [ suggestionsRowBlockName, { ...attributes } ]) ]
// 	))] ])
// }
// )

// const TEMPLATE = Array(2).fill().map((_, i) => {
// 	return ([ [ 'core/columns', {},  suggestions.splice(0,3).map((attributes) => (
// 		[ 'core/column', {},  [ suggestionsRowBlockName, { ...attributes } ] ]
// 	))] ])
// }
// )

// const TEMPLATE = Array(2).fill().map((_, i) => 
// 	[ 'core/columns', {},  suggestions.splice(0,3).map((attributes) => (
// 		[ 'core/column', {},  [
// 			[ suggestionsRowBlockName, { ...attributes } ],
// 		] ]
// 	))],
// )

export default function edit({ attributes, setAttributes }){

	//https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-templates.md#api
	const TEMPLATE = useMemo(() => {
		return Array(2).fill().map((_, i) => 
			[ 'core/columns', {},  suggestions.splice(0,3).map((attributes) => (
				[ 'core/column', {},  [
					[ suggestionsRowBlockName, { ...attributes } ],
				] ]
			))],
		)
	}, []);

    return (
		<Fragment>
			<InspectorControls>
				<PanelBody title='Advanced' initialOpen>
					<TextControl
                        type="text"
                        label="Additional CSS class(es)"
                        value={attributes.classNames}
                        onChange={ ( classNames ) => setAttributes({ classNames }) }
                    />				
				</PanelBody>
			</InspectorControls>
			<div className="cl-block-container-fw cl-block-container-fw-mobile">
                <div className={attributes.classNames} >
                    <div className="cl-block-suggestions-grid">
						<InnerBlocks
							template={TEMPLATE} 
							templateLock="all"
							allowedBlocks={[suggestionsRowBlockName, 'core/column', 'core/columns']}
						/>
                    </div>
                </div>
            </div>
		</Fragment>
    )
}