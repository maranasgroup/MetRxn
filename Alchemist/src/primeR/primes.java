package primeR;

import java.io.BufferedReader;
import java.io.FileReader;
import java.io.IOException;
import java.util.HashMap;
import java.util.LinkedList;
import java.util.Set;
import java.util.TreeMap;
import java.util.TreeSet;

public class primes {

	public static HashMap<Integer,Integer> getPrimesAsHash() {
		try {
			BufferedReader inputStream = new BufferedReader(new FileReader(
					"primes.txt"));
			String inLine = null;
			TreeMap<Integer, Integer> primesKey = new TreeMap<Integer, Integer>();
			HashMap<Integer,Integer> primeHash =  new HashMap<Integer, Integer>();
			try {
				while ((inLine = inputStream.readLine().trim()) != null) {
					//inLine = inputStream.readLine().trim();
					String[] split = inLine.split("\\b");
					for (int i = 0; i < split.length; i++) {
						if (!split[i].trim().equalsIgnoreCase("")) {
							primesKey.put(Integer.parseInt(split[i].trim()), 0);
						}
						
					}
				}
			} catch (NullPointerException e) {
				// TODO Auto-generated catch block
				//e.printStackTrace();
			}
			inputStream.close();
			
			Set<Integer> keySet = primesKey.keySet();
			int i = 1 ;
			for (Integer primeVal : keySet) {
				primeHash.put(i++, primeVal);
			}
			
			primeHash.put(0, 1);
			
			return primeHash;
		} catch (IOException e) {

			System.out.println("IOException:");
			e.printStackTrace();

		}
		return null;
	}
	public static TreeSet<Integer> getSortedPrime(){
		try {
			BufferedReader inputStream = new BufferedReader(new FileReader(
					"primes.txt"));
			String inLine = null;
			TreeSet<Integer> primesKey = new TreeSet<Integer>();
			
			String[] split;
			try {
				while ((inLine = inputStream.readLine().trim()) != null) {					
					split = inLine.split("\\b");
					for (int i = 0; i < split.length; i++) {
						if (!split[i].trim().equalsIgnoreCase("")) {
							primesKey.add(Integer.parseInt(split[i].trim()));
						}						
					}
				}
			} catch (NullPointerException e) {
				
			}
			inputStream.close();
			
			return primesKey;			
		} catch (IOException e) {

			System.out.println("IOException:");
			e.printStackTrace();

		}
		return null;
	}
	
	public static LinkedList<Integer> getSortedPrimeAsList(){
		LinkedList<Integer> returnVal = new LinkedList<>();
		returnVal.addAll(getSortedPrime());		
		return returnVal;
	}
	
	public static HashMap<Integer,Integer> getPrimeIndex(HashMap<Integer,Integer> primeHash){
		HashMap<Integer,Integer> returnVal = new HashMap<Integer,Integer>();
		Set<Integer> keySet = primeHash.keySet();
		for (Integer index : keySet) {
			returnVal.put(primeHash.get(index), index);
		}
		return returnVal;
	}
}
