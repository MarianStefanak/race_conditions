import os

os.fork() #2
os.fork() #4
os.fork() #8
os.fork() #16
os.fork() #32
os.fork() #64
os.fork() #128

ret = os.popen('curl -i http://localhost/PhpProject1/payment.php?balance=10' )


#import datetime
#a = datetime.datetime.now()

#os.system('curl -i http://localhost/PhpProject1/payment.php?balance=10')

#b = datetime.datetime.now()
#c = b - a

#print( c.seconds, c.microseconds / 1000 )
