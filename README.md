# Gene Size Guide #

**version: 0.0.1**

This module contains functionality to enable admin users to create size guides using page builder blocks

## Setup
composer require gene/sizeguide

## Product Config
Once installation is complete and setup upgrade has been ran, a new product attribute will be created 'size_guide'.

This will be shown in the product configuration under General > Size Charts.

## Size Guide Config
Size Guides can be created by heading to Content > Elements > Size Guide in the Magento Admin.

This is broken down into:

General config:
- Enable/Disable
- Title
- Store View

Then the next 3 sections are where the pagebuilder blocks will be created to create your size guides

- Recommended Size 
- Product Measurements
- Additional Content

## Notes
Currently this module contains no functionality to display size guides on the frontend, this will need to be implmented on a case by case basis using View Model, Product Repositry etc.


