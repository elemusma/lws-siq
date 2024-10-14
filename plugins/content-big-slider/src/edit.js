/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps, InnerBlocks, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { Button, PanelBody, __experimentalInputControl as InputControl,TextControl, } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { section_style, section_class, section_id, carousel_class,carousel_style,carousel_data_aos,carousel_data_aos_delay,carousel_data_aos_offset, gallery_images, gallery_images_class,gallery_images_style } = attributes;

	const [value, setValue] = useState('');

	const onSelectBackgroundImages = ( newBackgroundImages ) => {
		// console.log( newImages );
		setAttributes( { gallery_images: newBackgroundImages } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Section')} initialOpen={false}>
					<InputControl
						label="Section Style"
						value={section_style}
						onChange={(nextValue) => setAttributes({ section_style: nextValue })}
					/>
					<InputControl
						label="Section Class"
						value={section_class}
						onChange={(nextValue) => setAttributes({ section_class: nextValue })}
					/>
					<InputControl
						label="Section ID"
						value={section_id}
						onChange={(nextValue) => setAttributes({ section_id: nextValue })}
					/>
				</PanelBody>
				{/* <PanelBody title={__('Background Image')} initialOpen={false}>
					
				</PanelBody> */}
				<PanelBody title={__('Carousel Details')} initialOpen={false}>
				<InputControl
					label="Carousel Class"
					value={carousel_class}
					onChange={(nextValue) => setAttributes({ carousel_class: nextValue })}
				/>
				<InputControl
					label="Carousel Style"
					value={carousel_style}
					onChange={(nextValue) => setAttributes({ carousel_style: nextValue })}
				/>
				<InputControl
					label="Carousel Data AOS"
					value={carousel_data_aos}
					onChange={(nextValue) => setAttributes({ carousel_data_aos: nextValue })}
				/>
				<InputControl
					label="Carousel Data AOS Delay"
					value={carousel_data_aos_delay}
					onChange={(nextValue) => setAttributes({ carousel_data_aos_delay: nextValue })}
				/>
				<InputControl
					label="Carousel Data AOS Offset"
					value={carousel_data_aos_offset}
					onChange={(nextValue) => setAttributes({ carousel_data_aos_offset: nextValue })}
				/>
				</PanelBody>
				<PanelBody title={__('Carousel Images')} initialOpen={false}>
				<InputControl
						label="Gallery Image Class"
						value={gallery_images_class}
						onChange={(nextValue) => setAttributes({ gallery_images_class: nextValue })}
					/>
					<InputControl
						label="Gallery Image Style"
						value={gallery_images_style}
						onChange={(nextValue) => setAttributes({ gallery_images_style: nextValue })}
					/>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ onSelectBackgroundImages }
							type="image"
							multiple
							gallery
							value={ gallery_images.map(({id}) => id) }
							render={ ( { open } ) => (
								<button onClick={ open }>
									Open Media Library
								</button>
							) }
						/>
					</MediaUploadCheck>
					<Gallery
						gallery_images={gallery_images}
						gallery_columns={ 1 }
						setAttributes={setAttributes}
						/>
				</PanelBody>
				<PanelBody title={__('Code Block')} initialOpen={false}>
					<label style={{lineHeight:'2'}}>Code Block</label>
					<textarea
						id="sectionStyleTextarea"
						value={attributes.section_block}
						onChange={(event) => setAttributes({ section_block: event.target.value })}
						placeholder="Enter section block here"
						style={{width:'100%'}}
					/>
				</PanelBody>
				{/* <PanelBody title={__('Container')} initialOpen={false}>
					<InputControl
						label="Container Section Style"
						value={container_style}
						onChange={(nextValue) => setAttributes({ container_style: nextValue })}
					/>
					<InputControl
						label="Container Section Class"
						value={container_class}
						onChange={(nextValue) => setAttributes({ container_class: nextValue })}
					/>
					<InputControl
						label="Container Section ID"
						value={container_id}
						onChange={(nextValue) => setAttributes({ container_id: nextValue })}
					/>
				</PanelBody> */}
				{/* <PanelBody title={__('Row')} initialOpen={false}>
					<InputControl
						label="Row Style"
						value={row_style}
						onChange={(nextValue) => setAttributes({ row_style: nextValue })}
					/>
					<InputControl
						label="Row Class"
						value={row_class}
						onChange={(nextValue) => setAttributes({ row_class: nextValue })}
					/>
					<InputControl
						label="Row ID"
						value={row_id}
						onChange={(nextValue) => setAttributes({ row_id: nextValue })}
					/>
				</PanelBody> */}
				{/* <PanelBody title={__('Column')} initialOpen={false}>
					<InputControl
						label="Column Style"
						value={col_style}
						onChange={(nextValue) => setAttributes({ col_style: nextValue })}
					/>
					<InputControl
						label="Column Class"
						value={col_class}
						onChange={(nextValue) => setAttributes({ col_class: nextValue })}
					/>
					<InputControl
						label="Column ID"
						value={col_id}
						onChange={(nextValue) => setAttributes({ col_id: nextValue })}
					/>
					<InputControl
						label="Column Data AOS"
						value={col_data_aos}
						onChange={(nextValue) => setAttributes({ col_data_aos: nextValue })}
					/>
					<InputControl
						label="Column Data AOS Delay"
						value={col_data_aos_delay}
						onChange={(nextValue) => setAttributes({ col_data_aos_delay: nextValue })}
					/>
				</PanelBody> */}
			</InspectorControls>
			<section {...useBlockProps()}>
				{/* <img src={section_image} alt="" /> */}
				{ /* Your gallery rendering logic */ }
				{ gallery_images &&
					gallery_images.map( ( image ) => (
						
						<img
						key={ image.id }
						src={ image.url }
						alt={ image.alt }
						style={{width:'400px'}}
						/>

					) ) }
			<InnerBlocks />
			</section>
		</>
	);
}
// Define your Gallery component
const Gallery = ( { gallery_images, setAttributes } ) => {
    // Render your gallery based on the images and columns
    // You can use the images array to loop through and display the selected images

	const deleteImage = (id) => {
        setAttributes( { gallery_images: gallery_images.filter( ( image ) => image.id !== id ) } );
    }
    return (
        <div className={ `gallery columns-` }>
            { /* Your gallery rendering logic */ }
            { gallery_images &&
                gallery_images.map( ( image ) => (
                    <div>
                    <button 
                    onClick={()=>deleteImage(image.id)}
                    >X</button>
                    <img key={ image.id } src={ image.url } alt={ image.alt } />
                    </div>
                ) ) }
        </div>
    );
};