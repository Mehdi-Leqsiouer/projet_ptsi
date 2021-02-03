import sys


import math
from graphe import creer_graphe,creer_aretes,calcul_mat_poids

def calcul_dijsktra (graphe, sommet_start, sommet_fin=None): 
    
    """Extraction des sommets S du graphe"""
    sommets_S = [cle for cle in graphe.keys()]
    
    """Le sommet de départ existe-t-il?"""
    if sommet_start not in sommets_S:
        print ('Erreur: le noeud de départ {} n\'existe pas'.format(sommet_start))
        return
    
     
    """Vecteur des sommets complémentaires, qui n'ont pas encore été traités
       Au départ, E= S -{sommet_start}
    """
    sommets_E = sommets_S.copy()
    sommets_E.remove(sommet_start)
    
    """Matrice des poids"""
    poids = calcul_mat_poids(graphe)

    #print(poids)
    distances_E = {}
    distances_E[sommet_start] = 0
    """A COMPLETER """
    for sommet in sommets_E:
        if (sommet != sommet_start and poids[sommet_start][sommet] != math.inf):
            distances_E[sommet] = poids[sommet_start][sommet]
        else:
            distances_E[sommet] = math.inf
    
    #Dictionnaire des prédécesseurs
    pred = {}
    aretes_depart = creer_aretes(graphe,sommet_start)
    for v in aretes_depart:
        for v2 in v:
            pred[v2] = sommet_start
    #print(pred)
    sommet_u = min(sommets_E, key=(lambda k: distances_E[k]))
    #print(sommet_u)
    aretes_u = creer_aretes(graphe, sommet_u)  
    #print(aretes_u)
    while sommets_E:  
        sommet_u = min(sommets_E, key=(lambda k: distances_E[k]))
        #print(sommet_u)
        aretes_u = creer_aretes(graphe, sommet_u) 
        #print(aretes_u)
        for ar in aretes_u:        
            voisin_existe = False
            sommet_v = None
            for v in ar:
                if (v in sommets_E):
                    voisin_existe = True
                    sommet_v = v
                    if voisin_existe:   
                        #Relaxation: Mise à jour des distances
                        #A COMPLETER
                        if(distances_E[sommet_u] != math.inf):
                            dist = distances_E[sommet_u] + poids[sommet_u][sommet_v]
                        else:
                            dist = poids[sommet_u][sommet_v]
                        if (dist < distances_E[sommet_v] or distances_E[sommet_v] == math.inf):
                            distances_E[sommet_v] = dist
                            #print(pred)
                        if(sommet_v not in pred):
                            pred[sommet_v] = sommet_u
                #print(distances_E)
        #print(distances_E)      
        #Mise à jour des sommets non traités: retrait de sommet_u
        sommets_E.remove(sommet_u)
    #Calcul du chemin de sommet_start à sommet_fin
    #print(distances_E)
    if sommet_fin:
        chemin = []
        sommet_u = sommet_fin
        chemin.append(sommet_fin)
        while(sommet_u != sommet_start):
            for el in pred:
                if(el  == sommet_u):
                    chemin.append(pred[el])
                    sommet_u = pred[el]      
        return distances_E, chemin
    
    return distances_E


def main():
    g = creer_graphe("step4.dat")
    depart = sys.argv[1]
    arriver = sys.argv[2]
    #depart  = 'Reactor'
    #arriver = 'Navigations'
    dij = calcul_dijsktra(g, depart, arriver)
    distances = dij[0]
    chemin = dij[1]
    chemin.reverse()
    print("\nChemin {}".format(chemin))
    print("Poids : {}".format(distances[arriver]))
    print()
   # print()
   # print("---------- STEP 3 : All shortest path from each pair of rooms ----------")
   # d = floydWarshall(g)
    #print(d)

if __name__ == "__main__":
    main()