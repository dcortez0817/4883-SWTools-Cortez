"""Course: CMPS 4883
Assignemt: A07
Date: 3/15/19
Github username: dcortez0817
Repo url: https://github.com/dcortez0817/4883-SWTools-Cortez
Name: Darien Cortez
Description: 
    This program find the closest match in a specified folder of images 
    given the input name of the images. 
"""

# import the necessary packages
from skimage.measure import structural_similarity as ssim
import matplotlib.pyplot as plt
import numpy as np
import cv2

"""
Mean Squared Error => mse(imageA, imageB):

This function converts the images from unsigned 8-bit integers to floating points,
so we don’t run into any problems with modulus operations “wrapping around”. It then
subtracts pixel intensities of the images. This function squares the difference,
sums all the differences up, and dividing our sum of squares by the total number of pixels in the image.

Params: 
   imageA: first image we want to compare 
   imageB: second image we want to compare

Returns: 
   err
"""

def mse(imageA, imageB):
	# the 'Mean Squared Error' between the two images is the
	# sum of the squared difference between the two images;
	# NOTE: the two images must have the same dimension
	err = np.sum((imageA.astype("float") - imageB.astype("float")) ** 2)
	err /= float(imageA.shape[0] * imageA.shape[1])
	
	# return the MSE, the lower the error, the more "similar"
	# the two images are
	return err

"""
def compare_images(imageA, imageB, title):

This function compare stwo images using both MSE and SSIM (Structural Similarity
Index Measure).

Params: 
   imageA: first image we want to compare 
   imageB: second image we want to compare
   title: title of our figure

Returns: 
   gameid
   prints game id and places it in a file
"""

def compare_images(imageA, imageB, title):
	# compute the mean squared error and structural similarity
	# index for the images
	m = mse(imageA, imageB)
	s = ssim(imageA, imageB)
 
	# setup the figure
	fig = plt.figure(title)
	plt.suptitle("MSE: %.2f, SSIM: %.2f" % (m, s))
 
	# show first image
	ax = fig.add_subplot(1, 2, 1)
	plt.imshow(imageA, cmap = plt.cm.gray)
	plt.axis("off")
 
	# show the second image
	ax = fig.add_subplot(1, 2, 2)
	plt.imshow(imageB, cmap = plt.cm.gray)
	plt.axis("off")
 
	# show the images
	plt.show()

# load the images -- the original, the original + contrast,
# and the original + photoshop
original = cv2.imread("images/jp_gates_original.png")
contrast = cv2.imread("images/jp_gates_contrast.png")
shopped = cv2.imread("images/jp_gates_photoshopped.png")

# convert the images to grayscale
original = cv2.cvtColor(original, cv2.COLOR_BGR2GRAY)
contrast = cv2.cvtColor(contrast, cv2.COLOR_BGR2GRAY)
shopped = cv2.cvtColor(shopped, cv2.COLOR_BGR2GRAY)

# initialize the figure
fig = plt.figure("Images")
images = ("Original", original), ("Contrast", contrast), ("Photoshopped", shopped)

# loop over the images
for (i, (name, image)) in enumerate(images):
	# show the image
	ax = fig.add_subplot(1, 3, i + 1)
	ax.set_title(name)
	plt.imshow(image, cmap = plt.cm.gray)
	plt.axis("off")

# show the figure
plt.show()

# compare the images
compare_images(original, original, "Original vs. Original")
compare_images(original, contrast, "Original vs. Contrast")
compare_images(original, shopped, "Original vs. Photoshopped")