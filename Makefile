run: salida
	./salida assets/entrada.txt assets/salida.txt
salida: lex.yy.c instrucciones.tab.c
	gcc src/lex.yy.c src/instrucciones.tab.c -o salida -ly -lfl -lm
instrucciones.tab.c:
	bison -d src/instrucciones.y -o src/instrucciones.tab.c
lex.yy.c:
	flex -o src/lex.yy.c src/instrucciones.l
clean:
	rm src/lex.yy.c
	rm src/instrucciones.tab.c
	rm src/instrucciones.tab.h
	rm salida
	clear 

