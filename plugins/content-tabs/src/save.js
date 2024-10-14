/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

import { useBlockProps, InnerBlocks, RichText } from '@wordpress/block-editor';
import { RawHTML } from '@wordpress/element';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save( { attributes } ) {
	const blockProps = useBlockProps.save();
	let tabsRepeater = 0;

	const sanitizeTitleWithDashes = (title) => 
		title
		  .toLowerCase()                         // Convert to lowercase
		  .replace(/[^\w\s-]/g, '')              // Remove special characters
		  .trim()                                // Trim any leading/trailing spaces
		  .replace(/\s+/g, '-')                  // Replace spaces with dashes
		  .replace(/-+/g, '-');                  // Avoid multiple dashes
	  
	const TabContent = ({ code_block, img, alt, img_class, img_style, content }) => {
	return (
		<div className={``}>
			<RawHTML>{code_block}</RawHTML>

			{img && (
				<div className={''} style={{ display: 'inline-block' }}>
					<img
						src={img}
						alt={alt}
						className={img_class}
						style={{
							borderRadius: '50%',
							height: '100px',
							width: '100px',
							objectFit: 'cover',
							objectPosition: 'top',
							...img_style
						}}
					/>
				</div>
			)}

			<div className={`position-relative`} style={{ paddingLeft: '25px' }}>
				<p style={{ margin: '0px' }} className={`text-left`}>
					<RichText.Content value={content} />
				</p>
			</div>
		</div>
	);
};

	return (
		<div { ...blockProps }>
			<section
				className={ `position-relative ${ attributes.section_class }` }
				style={ `padding:50px 0;${ attributes.section_style }` }
				id={ attributes.section_id }
			>
				{/* <div className="column-wrapper"> */}
				{ attributes.section_image && (
					<img
						src={ attributes.section_image }
						alt=""
						className={ `w-100 h-100 position-absolute bg-img ${ attributes.section_image_class }` }
						style={ `top:0;left:0;object-fit:cover;pointer-events:none;${ attributes.section_image_style }` }
					/>
				) }

				<RawHTML>{ attributes.section_block }</RawHTML>

				<div
					className={ attributes.container_class }
					style={ attributes.container_style }
					id={ attributes.container_id }
				>
					<div
						className={ attributes.row_class }
						style={ attributes.row_style }
						id={ attributes.row_id }
					>


<div className={attributes.col_class} style={attributes.col_style} id={attributes.col_id} data-aos={attributes.col_data_aos} data-aos-delay={attributes.col_data_aos_delay} data-aos-offset={attributes.col_data_aos_delay_offset}>
<InnerBlocks.Content />
</div>



<div className={attributes.tab_class} style={attributes.tab_style} id={attributes.tab_id} data-aos={attributes.tab_data_aos} data-aos-delay={attributes.tab_data_aos_delay} data-aos-offset={attributes.tab_data_aos_delay_offset}>


<div className={`d-flex justify-content-center flex-wrap`}>
{
  attributes.tabs.map((tab, index) => {

	let sanitizedID = sanitizeTitleWithDashes(tab.title);
	let tabID = sanitizedID + '-' + index;

    return (
		<>
			{index == 0 ? (
				<p id={tabID} className={`d-block btn tab-title active ${tab.col_class}`} style={{ cursor: 'pointer' }}><RichText.Content value={tab.title} /></p>
			) :
			<p id={tabID} className={`d-block btn tab-title ${tab.col_class}`} style={{ cursor: 'pointer' }}><RichText.Content value={tab.title} /></p>
		}
	</>
    );
  })
}
</div>

<div style={{height:'30px'}} className={`spacer`}></div>

{/* <div className="tabs-wrapper" style={{display:'flex'}}> */}
{
  attributes.tabs.map((tab, index) => {
	let sanitizedID = sanitizeTitleWithDashes(tab.title);
	let tabID = sanitizedID + '-' + index;
	return (
		<>
		{index == 0 ? (
			<div className={`content-area w-100 ${tabID} activate position-relative`} style={{opacity: '1'}}>
				<TabContent 
			code_block={tab.code_block}
			img={tab.img}
			alt={tab.alt}
			img_class={tab.img_class}
			img_style={tab.img_style}
			content={tab.content}
		/>
			</div>
			) :
			<div className={`content-area w-100 ${tabID} position-absolute`} style={{opacity: '0'}}>
				<TabContent 
			code_block={tab.code_block}
			img={tab.img}
			alt={tab.alt}
			img_class={tab.img_class}
			img_style={tab.img_style}
			content={tab.content}
		/>
			</div>
			}
		</>
	); })}
{/* </div> */}


</div> {/* end of tab */}
				</div>
				</div>
			</section>
		</div>
	);
}
