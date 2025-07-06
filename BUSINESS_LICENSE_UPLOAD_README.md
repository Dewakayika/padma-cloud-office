# Business License Upload Functionality

## Overview
This implementation provides a complete business license upload system for the company onboarding process. The system includes file validation, drag-and-drop functionality, file preview, and secure file storage.

## Features

### Frontend Features
- **Drag & Drop Upload**: Users can drag files directly onto the upload area
- **File Type Validation**: Accepts PDF, JPG, JPEG, and PNG files only
- **File Size Validation**: Maximum file size of 10MB
- **File Preview**: Shows selected file name and size before upload
- **Visual Feedback**: Upload area changes color when file is selected
- **Remove File**: Users can remove selected files before submission
- **Loading States**: Form shows loading spinner during submission
- **Error Handling**: Displays validation errors with proper styling
- **Success Messages**: Shows success notifications after successful upload
- **Current File Display**: Shows previously uploaded files with view link

### Backend Features
- **Secure File Storage**: Files stored in `storage/app/public/business_licenses/`
- **File Validation**: Server-side validation for file type and size
- **Unique File Names**: Files renamed with timestamp and user ID for security
- **Old File Cleanup**: Automatically deletes old files when new ones are uploaded
- **Error Handling**: Comprehensive error handling with user-friendly messages
- **Database Integration**: File paths stored in `business_license_path` field

## File Structure

### Updated Files
1. **`resources/views/onboarding/company/step1.blade.php`**
   - Enhanced UI with file upload functionality
   - JavaScript for client-side validation and interactions
   - Drag and drop support
   - File preview and removal

2. **`app/Http/Controllers/CompanyOnboardingController.php`**
   - Improved file upload handling
   - Better validation and error handling
   - File storage management
   - Old file cleanup

3. **`resources/css/app.css`**
   - Custom CSS for form styling
   - File upload area styles
   - Loading animations

### Database
- **Field**: `business_license_path` (string, nullable)
- **Migration**: `2025_06_15_104139_add_onboarding_fields_to_companies_table.php`

## Setup Instructions

### 1. Storage Link
Create a symbolic link for file access:
```bash
php artisan storage:link
```

### 2. File Permissions
Ensure the storage directory is writable:
```bash
chmod -R 775 storage/
```

### 3. Database Migration
Run migrations if not already done:
```bash
php artisan migrate
```

## Usage

### For Users
1. Navigate to the onboarding step 1 page
2. Fill in company information (name, registration number, address)
3. For business license upload:
   - Click the upload area or drag a file onto it
   - Select a PDF, JPG, or PNG file (max 10MB)
   - Preview the file details
   - Remove if needed before submission
4. Submit the form

### For Developers
The system automatically:
- Validates file types and sizes
- Stores files securely
- Updates the database with file paths
- Handles errors gracefully
- Provides user feedback

## Security Features

1. **File Type Validation**: Only allows specific file types
2. **File Size Limits**: Prevents large file uploads
3. **Unique File Names**: Prevents file name conflicts
4. **Secure Storage**: Files stored outside web root
5. **Old File Cleanup**: Removes old files when new ones are uploaded

## Error Handling

The system handles various error scenarios:
- Invalid file types
- File size too large
- Upload failures
- Database errors
- Storage permission issues

## Browser Support

- Modern browsers with ES6 support
- Drag and drop functionality
- File API support
- CSS Grid and Flexbox support

## Customization

### File Types
To change allowed file types, update:
- Frontend: `allowedTypes` array in JavaScript
- Backend: `mimes` validation rule in controller

### File Size
To change maximum file size, update:
- Frontend: `maxSize` variable in JavaScript
- Backend: `max` validation rule in controller

### Storage Location
To change storage location, update:
- Backend: `storeAs` method parameters in controller

## Troubleshooting

### Common Issues

1. **Files not uploading**
   - Check storage permissions
   - Verify storage link exists
   - Check file size limits

2. **Files not displaying**
   - Ensure storage link is created
   - Check file paths in database
   - Verify file exists in storage

3. **Validation errors**
   - Check file type and size
   - Verify form data is complete
   - Check server error logs

### Debug Mode
Enable debug mode in `.env`:
```
APP_DEBUG=true
```

## Performance Considerations

- Files are stored in public storage for easy access
- Old files are automatically cleaned up
- File validation happens on both client and server
- Loading states prevent multiple submissions

## Future Enhancements

Potential improvements:
- Image compression for large files
- Multiple file upload support
- File encryption
- Cloud storage integration
- File preview for images
- Progress indicators for large files 