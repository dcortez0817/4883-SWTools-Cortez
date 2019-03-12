import os
import sys
from pil import Image, ImageDraw, ImageFont, ImageFilter

def img_to_ascii(**kwargs):
    """ 
    The ascii character set we use to replace pixels. 
    The grayscale pixel values are 0-255.
    0 - 25 = '#' (darkest character)
    250-255 = '.' (lightest character)
    """
    ascii_chars = [ u'🦍', 'A', '@', '%', 'S', '+', '<', '*', ':', ',', '.']
  
    width = kwargs.get('width',200)
    path = kwargs.get('path',None)

    im = Image.open(path)

    im = resize(im,width)

    w,h = im.size

    print(w,h)

    im = im.convert("L") # convert to grayscale

    imlist = list(im.getdata())

    i = 1
    for val in imlist:
        ch = ascii_chars[val // 25].decode('utf-8')
        sys.stdout.write()
        i += 1
        if i % width == 0:
            sys.stdout.write("\n")


    #Copy of original resized image
    original = im
    #Assign ascii character to grayscale ranges
    imlist[:] = [ascii_chars[val // 25] for val in imlist]
    """
    #Write ascii art to file
    f = open("demofile.txt", "w")
    i = 1
    for val in imlist:
        f.write(val)
        i += 1
        if i % width == 0:
            f.write("\n")
    f.close()
    """
    
    return original, imlist, w, h 

def resize(img,width):
    """
    This resizes the img while maintining aspect ratio. Keep in 
    mind that not all images scale to ascii perfectly because of the
    large discrepancy between line height line width (characters are 
    closer together horizontally then vertically)
    """
    
    wpercent = float(width / float(img.size[0]))
    hsize = int((float(img.size[1])*float(wpercent)))
    img = img.resize((width ,hsize), Image.ANTIALIAS)

    return img

if __name__=='__main__':
    path = 'vans.jpg'
Ascii = img_to_ascii(path=path,width=150)

def ascii_img_to_color(orig, ascii_im, w, h,font, size):
    #Open a new image using 'RGBA' (a colored image with alpha channel for transparency)
    #              color_type      (w,h)     (r,g,b,a) 
    #                   \           /            /
    #                    \         /            /
    newImg = Image.new('RGBA', (w*5,h*5), (255,255,255,255))
    
    #Open a TTF file and specify the font size
    fnt = ImageFont.truetype('Richland.ttf', size)

    #Get a drawing context for your new image
    drawOnMe = ImageDraw.Draw(newImg)

    #Convert original image to rgb
    rgb_im = orig.convert('RGB')

    i = 0
    ## Loop through your old image and write on the newImg
    for y in range(h):
        for x in range(w):
            #Ascii character from list
            c = ascii_im[i]
            #Increment
            i = i+1

            #Color of pixel in original img
            color = rgb_im.getpixel((x,y)) 

            #Add a character to some xy 
            #         location   character  ttf-font   color-tuple
            #            \         /        /            /
            #             \       /        /            /
            drawOnMe.text(((x*5)-1,(y*5)-1), c, font=fnt, fill=color)
            #Uncomment to overlap characters and output better image
            """drawOnMe.text(((x*5)-1,(y*5)+1), c, font=fnt, fill=color)
            drawOnMe.text(((x*5)+1,(y*5)-1), c, font=fnt, fill=color)
            drawOnMe.text(((x*5)+1,(y*5)+1), c, font=fnt, fill=color)"""
    return newImg



if __name__=='__main__':
    #Path to image (./input_images/picture.jpg) 
    input_path = sys.argv[1]
    #Path to output (./output_images/output.png)
    output_path = sys.argv[2]
    #Path to font type (./path_to_file/fonttype.ttf)
    font_type = sys.argv[3]
    #Size of font
    font_size = sys.argv[4]

    #Convert image to ascii
    orig, ascii_im, w, h = img_to_ascii(path=input_path,width=150)

    #Redrawn ascii image
    img = ascii_img_to_color(orig,ascii_im,w,h, font_type, int(font_size))

    #Display your new image 
    img.show()

    #Save the image
img.save(output_path)