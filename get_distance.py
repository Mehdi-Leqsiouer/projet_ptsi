from math import cos, asin, sqrt, pi
import sys

def distance(lat1, lon1, lat2, lon2):
    p = pi/180
    a = 0.5 - cos((lat2-lat1)*p)/2 + cos(lat1*p) * cos(lat2*p) * (1-cos((lon2-lon1)*p))/2
    return 12742 * asin(sqrt(a))

def temps(dist,mode):
    if mode == "Velo":
        v = 15
    elif mode == "Pieton":
        v = 3.6
    elif mode == "Voiture":
        v = 50
    
    t = dist/v
    return t
    
    
def main():
    """lat1 = sys.argv[1]
    lon1 = sys.argv[2]
    lat2 = sys.argv[3]
    lon2 = sys.argv[4]
    
    mode = sys.argv[5]+"";"""

    
    lat1 = 48.894435
    lon1 = 2.208686
    lat2 = 48.957898
    lon2 = 2.549657
    mode = "Voiture"
      
    res = distance(float(lat1),float(lon1),float(lat2),float(lon2))
    t = temps(res,mode)
    print("temps : "+str(t))
    print("{:.2f}".format(res))
    nb_heures = int(t%60)
    print(nb_heures)
    if nb_heures < 1:
        print(int(t*60))
    else:
        minutes = int(t*60)
        minutes = minutes - nb_heures*60
        print(minutes)

if __name__ == "__main__":
    main()