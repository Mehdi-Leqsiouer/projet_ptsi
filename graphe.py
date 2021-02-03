# -*- coding: utf-8 -*-
"""
Created on Sun Dec  6 20:54:38 2020

@author: Leqsi
"""
import math

def creer_graphe(fic):
    
    g = {}
    fichier = open(fic,"r")
    if not fichier:
        print("Fichier {} introuvable".format(fic))
        return
    
    for line in fichier:
        t=line.split()
        arete0 = {}
        arete1 = {}        
        
        if t[0] not in g:
            g[t[0]]={}
        else:
            arete0=g[t[0]]
        if t[1] not in g:
            g[t[1]]={}
        else:
            arete1=g[t[1]]
        arete0[t[1]]=int(t[2])
        arete1[t[0]]=int(t[2])
        g[t[0]]=arete0
        g[t[1]]=arete1
        
        
    fichier.close()
    return g

def creer_aretes(graphe, sommet=None):
    aretes = []
    
    if sommet:
        """On ne retourne que les aretes liées à sommet"""
        if sommet not in graphe:
            print("Erreur, le sommet {} ne se trouve pas dans le graphe".format(sommet))
            return
        aretes=list([graphe[sommet]])
        
        return aretes
    
    """sinon, on retourne toutes les aretes du graphe""" 
    for noeud in graphe.keys():
        for(noeud2, poids) in graphe[noeud].items():
            aretes.append([noeud, noeud2, poids])
    
    return aretes


def calcul_mat_poids(graphe):
    
    """Extraction des noeuds du graphe: ce sont les clés du dictionnaire"""
    Noeuds = [cle for cle in graphe.keys()]
    #print(Noeuds)
    """Extraction des aretes du graphe sous forme d'une liste de
        de tuples: (tail, head, poids)"""
    aretes_graphe = creer_aretes(graphe)
    #print("Aretes :",aretes_graphe)
    print()
    
    """Initialisation d'une matrice à 0"""
    poids = {}
    for noeud in Noeuds:
        poids[noeud] = {}
        for noeud2 in Noeuds:
            poids[noeud][noeud2]=math.inf

    #print("poids : ",poids)
    for tu in aretes_graphe:
        poids[tu[0]][tu[1]] = tu[2]
    return poids