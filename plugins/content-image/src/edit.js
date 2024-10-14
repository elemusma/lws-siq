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
export default function Edit({attributes, setAttributes}) {
	const { section_style, section_class, section_id, section_image, section_image_alt,section_image_class, section_image_style, section_block, container_style, container_class, container_id, row_style, row_class, row_id, col_style, col_class, col_id, col_data_aos,col_data_aos_delay, col_data_aos_offset, col_data_aos_duration, col_image,col_image_alt,col_image_style, col_image_class,col_image_id,col_image_data_aos, col_image_data_aos_delay, col_image_data_aos_offset, col_image_data_aos_duration, image_style,image_class,image_id } = attributes;

	const [value, setValue] = useState('');

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
				<PanelBody title={__('Background Image')} initialOpen={false}>
				<MediaUploadCheck>
  <MediaUpload
    onSelect={(media) => setAttributes({ section_image: media.url, section_image_alt: media.alt })}
    type="image"
    allowedTypes={['image']}
    value={section_image}
    render={({ open }) => (
      <div>
        {section_image && (
          <>
            <Button
              isLink
              isDestructive
              onClick={() => setAttributes({ section_image: '', section_image_alt: '' })}
            >
              {__('Remove Section Image')}
            </Button>
            <img src={section_image} alt={section_image_alt || 'Image'} />
            {section_image_alt && (
              <p>{__('Alt Text:')} {section_image_alt}</p>
            )}
          </>
        )}
        <Button
          onClick={open}
          icon="upload"
          className="editor-media-placeholder__button is-button is-default is-large"
        >
          {__('Select Section Image')}
        </Button>
      </div>
    )}
  />
</MediaUploadCheck>

					<InputControl
						label="Background Image Class"
						value={section_image_class}
						onChange={(nextValue) => setAttributes({ section_image_class: nextValue })}
					/>
					<InputControl
						label="Background Image Style"
						value={section_image_style}
						onChange={(nextValue) => setAttributes({ section_image_style: nextValue })}
					/>
				</PanelBody>
				<PanelBody title={__('Code Block')} initialOpen={false}>
				{/* <InputControl
						label="Code Block"
						value={section_block}
						onChange={(nextValue) => setAttributes({ section_block: nextValue })}
					/> */}
					<label style={{lineHeight:'2'}}>Code Block</label>
					<textarea
						id="sectionStyleTextarea"
						value={attributes.section_block}
						onChange={(event) => setAttributes({ section_block: event.target.value })}
						placeholder="Enter section block here"
						style={{width:'100%',height:'100px'}}
					/>
				</PanelBody>
				<PanelBody title={__('Container')} initialOpen={false}>
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
				</PanelBody>
				<PanelBody title={__('Row')} initialOpen={false}>
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
				</PanelBody>
				<PanelBody title={__('Column')} initialOpen={false}>
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
						label="Data AOS"
						value={col_data_aos}
						onChange={(nextValue) => setAttributes({ col_data_aos: nextValue })}
					/>
					<InputControl
						label="Data AOS Delay"
						value={col_data_aos_delay}
						onChange={(nextValue) => setAttributes({ col_data_aos_delay: nextValue })}
					/>
					<InputControl
						label="Data AOS Offset"
						value={col_data_aos_offset}
						onChange={(nextValue) => setAttributes({ col_data_aos_offset: nextValue })}
					/>
					<InputControl
						label="Data AOS Duration"
						value={col_data_aos_duration}
						onChange={(nextValue) => setAttributes({ col_data_aos_duration: nextValue })}
					/>
				</PanelBody>
				<PanelBody title={__('Image')} initialOpen={false}>
				<InputControl
						label="Column Image Class"
						value={col_image_class}
						onChange={(nextValue) => setAttributes({ col_image_class: nextValue })}
					/>
					<InputControl
						label="Column Image Style"
						value={col_image_style}
						onChange={(nextValue) => setAttributes({ col_image_style: nextValue })}
					/>
					<InputControl
						label="Column Image ID"
						value={col_image_id}
						onChange={(nextValue) => setAttributes({ col_image_id: nextValue })}
					/>
				<InputControl
						label="Column Image Data AOS"
						value={col_image_data_aos}
						onChange={(nextValue) => setAttributes({ col_image_data_aos: nextValue })}
					/>
					<InputControl
						label="Column Image Data AOS Delay"
						value={col_image_data_aos_delay}
						onChange={(nextValue) => setAttributes({ col_image_data_aos_delay: nextValue })}
					/>
					<InputControl
						label="Column Image Data AOS Offset"
						value={col_image_data_aos_offset}
						onChange={(nextValue) => setAttributes({ col_image_data_aos_offset: nextValue })}
					/>
					<InputControl
						label="Column Image Data AOS Duration"
						value={col_image_data_aos_duration}
						onChange={(nextValue) => setAttributes({ col_image_data_aos_duration: nextValue })}
					/>
				<MediaUploadCheck>
  <MediaUpload
    onSelect={(media) => setAttributes({ col_image: media.url, col_image_alt: media.alt })}
    type="image"
    allowedTypes={['image']}
    value={col_image}
    render={({ open }) => (
      <div>
        {col_image && (
          <>
            <Button
              isLink
              isDestructive
              onClick={() => setAttributes({ col_image: '', col_image_alt: '' })}
            >
              {__('Remove Col Image')}
            </Button>
            {/* Display the image with alt text */}
            <img src={col_image} alt={col_image_alt || 'Default alt text'} />
            {col_image_alt && (
              <p>{__('Alt Text:')} {col_image_alt}</p>
            )}
          </>
        )}
        <Button
          onClick={open}
          icon="upload"
          className="editor-media-placeholder__button is-button is-default is-large"
        >
          {__('Select Col Image')}
        </Button>
      </div>
    )}
  />
</MediaUploadCheck>
<InputControl
						label="Image Class"
						value={image_class}
						onChange={(nextValue) => setAttributes({ image_class: nextValue })}
					/>
					<InputControl
						label="Image Style"
						value={image_style}
						onChange={(nextValue) => setAttributes({ image_style: nextValue })}
					/>
					<InputControl
						label="Image ID"
						value={image_id}
						onChange={(nextValue) => setAttributes({ image_id: nextValue })}
					/>
					
				</PanelBody>
			</InspectorControls>
			<section {...useBlockProps()} style={{background:'gray',padding:'25px 15px'}}>
				<img src={section_image} alt="" />
				{console.log(section_image)}
				<div style={{ display: 'flex' }}>
  <div style={{ flex: '1', marginRight: '20px', width: '50%' }}>
    <InnerBlocks />
  </div>
  <div style={{ flex: '1', width: '50%' }}>
    <img src={col_image} alt="" style={{ width: '100%', height: 'auto' }} />
  </div>
</div>

			</section>
		</>
	);
}
